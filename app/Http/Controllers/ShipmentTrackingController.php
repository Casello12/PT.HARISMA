<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentTracking;
use Illuminate\Http\Request;

class ShipmentTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tracking = ShipmentTracking::with(['shipment', 'shipment.salesOrder', 'shipment.warehouse'])
            ->orderBy('tracking_date', 'desc')
            ->paginate(10);
        return view('shipment-tracking.index', compact('tracking'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shipments = Shipment::where('status', '!=', 'delivered')
            ->where('status', '!=', 'cancelled')
            ->get();
        return view('shipment-tracking.create', compact('shipments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'status' => 'required|in:pending,in_transit,delivered,cancelled',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['tracking_date'] = now();

        ShipmentTracking::create($validated);

        // Update shipment status
        $shipment = Shipment::find($validated['shipment_id']);
        $shipment->update(['status' => $validated['status']]);

        return redirect()->route('shipment-tracking.index')
            ->with('success', 'Tracking berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShipmentTracking $tracking)
    {
        $tracking->load(['shipment', 'shipment.salesOrder', 'shipment.warehouse']);
        return view('shipment-tracking.show', compact('tracking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipmentTracking $tracking)
    {
        $shipments = Shipment::all();
        return view('shipment-tracking.edit', compact('tracking', 'shipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShipmentTracking $tracking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_transit,delivered,cancelled',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $tracking->update($validated);

        // Update shipment status
        $tracking->shipment->update(['status' => $validated['status']]);

        return redirect()->route('shipment-tracking.index')
            ->with('success', 'Tracking berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipmentTracking $tracking)
    {
        $tracking->delete();

        return redirect()->route('shipment-tracking.index')
            ->with('success', 'Tracking berhasil dihapus.');
    }

    /**
     * Get realtime tracking data (API endpoint)
     */
    public function getRealtimeTracking(Shipment $shipment)
    {
        $tracking = ShipmentTracking::where('shipment_id', $shipment->id)
            ->orderBy('tracking_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'tracking' => $tracking,
            'shipment' => $shipment->load('salesOrder.customer')
        ]);
    }
}