<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Product;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SalesOrder::with(['customer', 'sales'])->orderBy('order_date', 'desc')->paginate(10);
        return view('sales-orders.index', compact('salesOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $sales = Sales::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::where('is_active', true)->orderBy('name')->get();
        return view('sales-orders.create', compact('customers', 'sales', 'products', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sales_id' => 'nullable|exists:sales,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'order_date' => 'required|date',
            'required_date' => 'nullable|date',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'status' => 'required|in:draft,pending_confirmation,confirmed,awaiting_payment,payment_verified,processing,packing,ready_to_ship,shipped,in_transit,delivered,completed,cancelled',
            'customer_notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.notes' => 'nullable|string',
        ]);

        // Generate order number
        $validated['order_number'] = 'SO-' . now()->format('Ymd') . '-' . str_pad(SalesOrder::count() + 1, 4, '0');
        $validated['discount_amount'] = $validated['discount_amount'] ?? 0;
        $validated['discount_percentage'] = $validated['discount_percentage'] ?? 0;
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;
        $validated['tax_percentage'] = $validated['tax_percentage'] ?? 0;
        $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'draft';
        $validated['paid_amount'] = 0;
        $validated['remaining_amount'] = $validated['grand_total'];

        $items = $validated['items'];
        unset($validated['items']);

        $salesOrder = SalesOrder::create($validated);

        // Save items
        foreach ($items as $item) {
            $item['sales_order_id'] = $salesOrder->id;
            $item['subtotal'] = $item['quantity'] * $item['unit_price'];
            $item['discount_amount'] = $item['discount_amount'] ?? 0;
            $item['discount_percentage'] = $item['discount_percentage'] ?? 0;
            $item['tax_amount'] = $item['tax_amount'] ?? 0;
            $item['tax_percentage'] = $item['tax_percentage'] ?? 0;
            $item['total_amount'] = $item['subtotal'] - $item['discount_amount'] + $item['tax_amount'];
            
            SalesOrderItem::create($item);
        }

        return redirect()->route('sales-orders.index')
            ->with('success', 'Sales Order berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load(['customer', 'sales', 'items.product', 'invoices', 'shipments']);
        return view('sales-orders.show', compact('salesOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $sales = Sales::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::where('is_active', true)->orderBy('name')->get();
        $salesOrder->load('items');
        return view('sales-orders.edit', compact('salesOrder', 'customers', 'sales', 'products', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sales_id' => 'nullable|exists:sales,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'order_date' => 'required|date',
            'required_date' => 'nullable|date',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'status' => 'required|in:draft,pending_confirmation,confirmed,awaiting_payment,payment_verified,processing,packing,ready_to_ship,shipped,in_transit,delivered,completed,cancelled',
            'customer_notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.notes' => 'nullable|string',
        ]);

        $validated['discount_amount'] = $validated['discount_amount'] ?? 0;
        $validated['discount_percentage'] = $validated['discount_percentage'] ?? 0;
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;
        $validated['tax_percentage'] = $validated['tax_percentage'] ?? 0;
        $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;
        $validated['remaining_amount'] = $validated['grand_total'] - $salesOrder->paid_amount;

        $items = $validated['items'];
        unset($validated['items']);

        $salesOrder->update($validated);

        // Delete existing items
        $salesOrder->items()->delete();

        // Save new items
        foreach ($items as $item) {
            $item['sales_order_id'] = $salesOrder->id;
            $item['subtotal'] = $item['quantity'] * $item['unit_price'];
            $item['discount_amount'] = $item['discount_amount'] ?? 0;
            $item['discount_percentage'] = $item['discount_percentage'] ?? 0;
            $item['tax_amount'] = $item['tax_amount'] ?? 0;
            $item['tax_percentage'] = $item['tax_percentage'] ?? 0;
            $item['total_amount'] = $item['subtotal'] - $item['discount_amount'] + $item['tax_amount'];
            
            SalesOrderItem::create($item);
        }

        return redirect()->route('sales-orders.index')
            ->with('success', 'Sales Order berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'draft' && $salesOrder->status !== 'cancelled') {
            return redirect()->route('sales-orders.index')
                ->with('error', 'Sales Order tidak dapat dihapus karena status bukan draft atau cancelled.');
        }

        $salesOrder->delete();

        return redirect()->route('sales-orders.index')
            ->with('success', 'Sales Order berhasil dihapus.');
    }
}
