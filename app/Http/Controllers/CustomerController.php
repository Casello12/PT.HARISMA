<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\Invoice;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display product catalog
     */
    public function catalog(Request $request)
    {
        $query = Product::with(['category', 'brand', 'warehouseStocks'])
            ->where('is_active', true);
        
        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by brand
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        
        if ($sortBy === 'price') {
            $query->orderBy('selling_price', $sortOrder);
        } elseif ($sortBy === 'name') {
            $query->orderBy('name', $sortOrder);
        } elseif ($sortBy === 'stock') {
            $query->withCount('warehouseStocks as total_stock')->orderBy('total_stock', $sortOrder);
        }
        
        $products = $query->paginate(12);
        
        return view('customer.catalog', compact('products'));
    }

    /**
     * Display customer orders
     */
    public function orders()
    {
        $orders = SalesOrder::where('customer_id', Auth::id())
            ->with(['items.product', 'invoice', 'shipment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.orders', compact('orders'));
    }

    /**
     * Display customer order detail
     */
    public function orderDetail(SalesOrder $salesOrder)
    {
        if ($salesOrder->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $salesOrder->load(['items.product', 'invoice', 'shipment']);
        
        return view('customer.order-detail', compact('salesOrder'));
    }

    /**
     * Display customer invoices
     */
    public function invoices()
    {
        $invoices = Invoice::whereHas('salesOrder', function($query) {
            $query->where('customer_id', Auth::id());
        })
            ->with(['salesOrder', 'payments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.invoices', compact('invoices'));
    }

    /**
     * Display customer shipments/tracking
     */
    public function shipments()
    {
        $shipments = Shipment::whereHas('salesOrder', function($query) {
            $query->where('customer_id', Auth::id());
        })
            ->with(['salesOrder', 'tracking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.shipments', compact('shipments'));
    }

    /**
     * Display customer profile
     */
    public function profile()
    {
        $customer = Auth::user();
        return view('customer.profile', compact('customer'));
    }

    /**
     * Update customer profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        
        Auth::user()->update($validated);
        
        return redirect()->route('customer.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
