<?php

namespace App\Http\Controllers;

use App\Models\WarehouseStock;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouseStocks = WarehouseStock::with(['warehouse', 'product'])->orderBy('warehouse_id')->orderBy('product_id')->paginate(10);
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('warehouse-stocks.index', compact('warehouseStocks', 'warehouses', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('warehouse-stocks.create', compact('warehouses', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'average_cost' => 'nullable|numeric|min:0',
        ]);

        $validated['reserved_quantity'] = 0;
        $validated['available_quantity'] = $validated['quantity'];
        $validated['average_cost'] = $validated['average_cost'] ?? 0;

        // Check if stock already exists for this warehouse and product
        $existingStock = WarehouseStock::where('warehouse_id', $validated['warehouse_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingStock) {
            return redirect()->route('warehouse-stocks.index')
                ->with('error', 'Stok untuk produk ini di gudang ini sudah ada. Gunakan fitur Stock Movement untuk menambah stok.');
        }

        WarehouseStock::create($validated);

        return redirect()->route('warehouse-stocks.index')
            ->with('success', 'Stok gudang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WarehouseStock $warehouseStock)
    {
        $warehouseStock->load(['warehouse', 'product', 'stockMovements']);
        return view('warehouse-stocks.show', compact('warehouseStock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WarehouseStock $warehouseStock)
    {
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('warehouse-stocks.edit', compact('warehouseStock', 'warehouses', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WarehouseStock $warehouseStock)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'average_cost' => 'nullable|numeric|min:0',
        ]);

        $validated['available_quantity'] = $validated['quantity'] - $warehouseStock->reserved_quantity;
        $validated['average_cost'] = $validated['average_cost'] ?? $warehouseStock->average_cost;

        $warehouseStock->update($validated);

        return redirect()->route('warehouse-stocks.index')
            ->with('success', 'Stok gudang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WarehouseStock $warehouseStock)
    {
        if ($warehouseStock->quantity > 0) {
            return redirect()->route('warehouse-stocks.index')
                ->with('error', 'Stok gudang tidak dapat dihapus karena masih memiliki stok.');
        }

        $warehouseStock->delete();

        return redirect()->route('warehouse-stocks.index')
            ->with('success', 'Stok gudang berhasil dihapus.');
    }
    
    /**
     * Add stock to warehouse
     */
    public function addStock(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $warehouseStock = WarehouseStock::where('warehouse_id', $validated['warehouse_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if (!$warehouseStock) {
            // Create new warehouse stock entry
            $warehouseStock = WarehouseStock::create([
                'warehouse_id' => $validated['warehouse_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'reserved_quantity' => 0,
                'available_quantity' => $validated['quantity'],
                'average_cost' => $validated['unit_cost'],
                'last_stock_in' => now(),
            ]);
        } else {
            // Update existing stock
            $oldQuantity = $warehouseStock->quantity;
            $oldAverageCost = $warehouseStock->average_cost;
            
            // Calculate new average cost
            $totalValue = ($oldQuantity * $oldAverageCost) + ($validated['quantity'] * $validated['unit_cost']);
            $newQuantity = $oldQuantity + $validated['quantity'];
            $newAverageCost = $totalValue / $newQuantity;
            
            $warehouseStock->update([
                'quantity' => $newQuantity,
                'available_quantity' => $newQuantity - $warehouseStock->reserved_quantity,
                'average_cost' => $newAverageCost,
                'last_stock_in' => now(),
            ]);
        }

        // Create stock movement record
        \App\Models\StockMovement::create([
            'reference_number' => $validated['reference_number'] ?? 'STM-' . now()->format('Ymd') . '-' . rand(1000, 9999),
            'product_id' => $validated['product_id'],
            'warehouse_id' => $validated['warehouse_id'],
            'type' => 'in',
            'quantity' => $validated['quantity'],
            'before_quantity' => $warehouseStock->quantity - $validated['quantity'],
            'after_quantity' => $warehouseStock->quantity,
            'reference_type' => 'manual',
            'reference_id' => null,
            'unit_cost' => $validated['unit_cost'],
            'total_cost' => $validated['quantity'] * $validated['unit_cost'],
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('warehouse-stocks.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }
}
