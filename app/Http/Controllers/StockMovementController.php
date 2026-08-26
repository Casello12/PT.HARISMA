<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockMovements = StockMovement::with(['warehouse', 'product', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('stock-movements.index', compact('stockMovements', 'warehouses', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('stock-movements.create', compact('warehouses', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,transfer',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'nullable|numeric|min:0',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $validated['reference_number'] = $validated['reference_number'] ?? 'STM-' . now()->format('Ymd') . '-' . rand(1000, 9999);
        $validated['unit_cost'] = $validated['unit_cost'] ?? 0;
        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];
        $validated['created_by'] = auth()->id();

        // Get current stock
        $warehouseStock = \App\Models\WarehouseStock::where('warehouse_id', $validated['warehouse_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if (!$warehouseStock) {
            return redirect()->route('stock-movements.index')
                ->with('error', 'Stok untuk produk ini di gudang ini belum ada. Buat stok terlebih dahulu.');
        }

        $validated['before_quantity'] = $warehouseStock->quantity;

        // Update stock based on movement type
        if ($validated['type'] === 'in') {
            $validated['after_quantity'] = $warehouseStock->quantity + $validated['quantity'];
            
            // Update warehouse stock
            $warehouseStock->update([
                'quantity' => $validated['after_quantity'],
                'available_quantity' => $validated['after_quantity'] - $warehouseStock->reserved_quantity,
                'last_stock_in' => now(),
            ]);
        } elseif ($validated['type'] === 'out') {
            if ($warehouseStock->available_quantity < $validated['quantity']) {
                return redirect()->route('stock-movements.index')
                    ->with('error', 'Stok tidak mencukupi untuk pengeluaran ini.');
            }
            
            $validated['after_quantity'] = $warehouseStock->quantity - $validated['quantity'];
            
            // Update warehouse stock
            $warehouseStock->update([
                'quantity' => $validated['after_quantity'],
                'available_quantity' => $validated['after_quantity'] - $warehouseStock->reserved_quantity,
                'last_stock_out' => now(),
            ]);
        }

        StockMovement::create($validated);

        return redirect()->route('stock-movements.index')
            ->with('success', 'Pergerakan stok berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        $stockMovement->load(['warehouse', 'product', 'createdBy']);
        return view('stock-movements.show', compact('stockMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        // Stock movements should not be editable after creation
        return redirect()->route('stock-movements.show', $stockMovement)
            ->with('error', 'Pergerakan stok tidak dapat diedit setelah dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        // Stock movements should not be editable
        return redirect()->route('stock-movements.show', $stockMovement)
            ->with('error', 'Pergerakan stok tidak dapat diedit setelah dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        // Stock movements should not be deleted to maintain audit trail
        return redirect()->route('stock-movements.index')
            ->with('error', 'Pergerakan stok tidak dapat dihapus untuk menjaga audit trail.');
    }
}
