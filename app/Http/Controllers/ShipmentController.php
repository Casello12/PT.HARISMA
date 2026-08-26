<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentTracking;
use App\Models\SalesOrder;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Shipment::with(['salesOrder', 'warehouse', 'tracking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salesOrders = SalesOrder::whereIn('status', ['payment_verified', 'processing', 'packing', 'ready_to_ship'])
            ->whereDoesntHave('shipment')
            ->with('customer')
            ->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        return view('shipments.create', compact('salesOrders', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'shipping_date' => 'required|date',
            'estimated_delivery_date' => 'nullable|date|after_or_equal:shipping_date',
            'carrier' => 'required|string|max:255',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Generate automatic shipment number
        $latestShipment = Shipment::orderBy('id', 'desc')->first();
        $nextId = $latestShipment ? $latestShipment->id + 1 : 1;
        $validated['shipment_number'] = 'SHP-' . str_pad($nextId, 4, '0');
        $validated['status'] = 'pending';
        $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;

        $shipment = Shipment::create($validated);

        // Create shipment items from sales order items
        $salesOrder = SalesOrder::with('items')->find($validated['sales_order_id']);
        foreach ($salesOrder->items as $item) {
            ShipmentItem::create([
                'shipment_id' => $shipment->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'subtotal' => $item->subtotal,
            ]);
        }

        // Create initial tracking
        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'status' => 'pending',
            'location' => 'Warehouse',
            'notes' => 'Shipment created',
            'tracking_date' => now(),
        ]);

        // Update sales order status
        $salesOrder->update(['status' => 'shipped']);

        return redirect()->route('shipments.index')
            ->with('success', 'Pengiriman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        $shipment->load(['salesOrder', 'salesOrder.customer', 'warehouse', 'items.product', 'tracking']);
        return view('shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        return view('shipments.edit', compact('shipment', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'shipping_date' => 'required|date',
            'estimated_delivery_date' => 'nullable|date|after_or_equal:shipping_date',
            'carrier' => 'required|string|max:255',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_transit,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;

        $shipment->update($validated);

        // Add tracking update if status changed
        if ($shipment->wasChanged('status')) {
            ShipmentTracking::create([
                'shipment_id' => $shipment->id,
                'status' => $validated['status'],
                'location' => $validated['status'] === 'delivered' ? 'Customer Location' : 'In Transit',
                'notes' => 'Status updated to ' . $validated['status'],
                'tracking_date' => now(),
            ]);
        }

        return redirect()->route('shipments.index')
            ->with('success', 'Pengiriman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        if ($shipment->status === 'delivered') {
            return redirect()->route('shipments.index')
                ->with('error', 'Pengiriman yang sudah dikirim tidak dapat dihapus.');
        }

        // Restore sales order status
        $shipment->salesOrder->update(['status' => 'approved']);

        $shipment->delete();

        return redirect()->route('shipments.index')
            ->with('success', 'Pengiriman berhasil dihapus.');
    }

    /**
     * Update tracking status (realtime endpoint)
     */
    public function updateTracking(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_transit,delivered,cancelled',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $shipment->update(['status' => $validated['status']]);

        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'status' => $validated['status'],
            'location' => $validated['location'],
            'notes' => $validated['notes'],
            'tracking_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tracking berhasil diperbarui',
            'shipment' => $shipment->load('tracking')
        ]);
    }

    /**
     * Get shipment tracking history (realtime endpoint)
     */
    public function getTracking(Shipment $shipment)
    {
        $shipment->load(['tracking' => function($query) {
            $query->orderBy('tracking_date', 'desc');
        }]);

        return response()->json([
            'success' => true,
            'shipment' => $shipment
        ]);
    }
}