<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\WarehouseStock;
use App\Models\StockMovement;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display sales report page
     */
    public function salesIndex()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $sales = \App\Models\Sales::where('is_active', true)->orderBy('name')->get();
        
        return view('reports.sales', compact('customers', 'sales'));
    }

    /**
     * Generate sales report
     */
    public function salesGenerate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_id' => 'nullable|exists:customers,id',
            'sales_id' => 'nullable|exists:sales,id',
            'status' => 'nullable|in:draft,pending_confirmation,confirmed,awaiting_payment,payment_verified,processing,packing,ready_to_ship,shipped,in_transit,delivered,completed,cancelled',
        ]);

        $query = SalesOrder::with(['customer', 'sales', 'items.product'])
            ->whereBetween('order_date', [$validated['start_date'], $validated['end_date']]);

        if (!empty($validated['customer_id'])) {
            $query->where('customer_id', $validated['customer_id']);
        }

        if (!empty($validated['sales_id'])) {
            $query->where('sales_id', $validated['sales_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $salesOrders = $query->orderBy('order_date', 'desc')->get();

        $totalOrders = $salesOrders->count();
        $totalRevenue = $salesOrders->sum('grand_total');
        $totalPaid = $salesOrders->sum('paid_amount');
        $totalPending = $salesOrders->sum('remaining_amount');

        return view('reports.sales-result', compact(
            'salesOrders',
            'totalOrders',
            'totalRevenue',
            'totalPaid',
            'totalPending',
            'validated'
        ));
    }

    /**
     * Export sales report to PDF
     */
    public function salesPdf(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_id' => 'nullable|exists:customers,id',
            'sales_id' => 'nullable|exists:sales,id',
            'status' => 'nullable|in:draft,pending_confirmation,confirmed,awaiting_payment,payment_verified,processing,packing,ready_to_ship,shipped,in_transit,delivered,completed,cancelled',
        ]);

        $query = SalesOrder::with(['customer', 'sales', 'items.product'])
            ->whereBetween('order_date', [$validated['start_date'], $validated['end_date']]);

        if (!empty($validated['customer_id'])) {
            $query->where('customer_id', $validated['customer_id']);
        }

        if (!empty($validated['sales_id'])) {
            $query->where('sales_id', $validated['sales_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $salesOrders = $query->orderBy('order_date', 'desc')->get();

        $totalOrders = $salesOrders->count();
        $totalRevenue = $salesOrders->sum('grand_total');
        $totalPaid = $salesOrders->sum('paid_amount');
        $totalPending = $salesOrders->sum('remaining_amount');

        $customerName = !empty($validated['customer_id']) ? Customer::find($validated['customer_id'])->name : 'Semua Customer';
        $salesName = !empty($validated['sales_id']) ? \App\Models\Sales::find($validated['sales_id'])->name : 'Semua Sales';
        $statusText = !empty($validated['status']) ? ucfirst(str_replace('_', ' ', $validated['status'])) : 'Semua Status';

        $pdf = PDF::loadView('reports.sales-pdf', compact(
            'salesOrders',
            'totalOrders',
            'totalRevenue',
            'totalPaid',
            'totalPending',
            'validated',
            'customerName',
            'salesName',
            'statusText'
        ));

        return $pdf->download('laporan-penjualan-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Display stock report page
     */
    public function stockIndex()
    {
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        
        return view('reports.stock', compact('warehouses', 'products', 'categories'));
    }

    /**
     * Generate stock report
     */
    public function stockGenerate(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $query = WarehouseStock::with(['warehouse', 'product.category', 'product.brand']);

        if (!empty($validated['warehouse_id'])) {
            $query->where('warehouse_id', $validated['warehouse_id']);
        }

        if (!empty($validated['product_id'])) {
            $query->where('product_id', $validated['product_id']);
        }

        if (!empty($validated['category_id'])) {
            $query->whereHas('product', function($q) use ($validated) {
                $q->where('category_id', $validated['category_id']);
            });
        }

        $warehouseStocks = $query->orderBy('warehouse_id')->orderBy('product_id')->get();

        $totalProducts = $warehouseStocks->count();
        $totalQuantity = $warehouseStocks->sum('quantity');
        $totalValue = $warehouseStocks->sum(function($stock) {
            return $stock->quantity * $stock->average_cost;
        });

        return view('reports.stock-result', compact(
            'warehouseStocks',
            'totalProducts',
            'totalQuantity',
            'totalValue',
            'validated'
        ));
    }

    /**
     * Export stock report to PDF
     */
    public function stockPdf(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $query = WarehouseStock::with(['warehouse', 'product.category', 'product.brand']);

        if (!empty($validated['warehouse_id'])) {
            $query->where('warehouse_id', $validated['warehouse_id']);
        }

        if (!empty($validated['product_id'])) {
            $query->where('product_id', $validated['product_id']);
        }

        if (!empty($validated['category_id'])) {
            $query->whereHas('product', function($q) use ($validated) {
                $q->where('category_id', $validated['category_id']);
            });
        }

        $warehouseStocks = $query->orderBy('warehouse_id')->orderBy('product_id')->get();

        $totalProducts = $warehouseStocks->count();
        $totalQuantity = $warehouseStocks->sum('quantity');
        $totalValue = $warehouseStocks->sum(function($stock) {
            return $stock->quantity * $stock->average_cost;
        });

        $warehouseName = !empty($validated['warehouse_id']) ? Warehouse::find($validated['warehouse_id'])->name : 'Semua Gudang';
        $productName = !empty($validated['product_id']) ? Product::find($validated['product_id'])->name : 'Semua Produk';
        $categoryName = !empty($validated['category_id']) ? \App\Models\Category::find($validated['category_id'])->name : 'Semua Kategori';

        $pdf = PDF::loadView('reports.stock-pdf', compact(
            'warehouseStocks',
            'totalProducts',
            'totalQuantity',
            'totalValue',
            'validated',
            'warehouseName',
            'productName',
            'categoryName'
        ));

        return $pdf->download('laporan-stok-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Display payment report page
     */
    public function paymentIndex()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        
        return view('reports.payment', compact('customers'));
    }

    /**
     * Generate payment report
     */
    public function paymentGenerate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'nullable|in:pending,verified,rejected',
        ]);

        $query = Payment::with(['invoice.customer', 'invoice.salesOrder'])
            ->whereBetween('payment_date', [$validated['start_date'], $validated['end_date']]);

        if (!empty($validated['customer_id'])) {
            $query->whereHas('invoice', function($q) use ($validated) {
                $q->where('customer_id', $validated['customer_id']);
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        $totalPayments = $payments->count();
        $totalAmount = $payments->sum('amount');
        $totalVerified = $payments->where('status', 'verified')->sum('amount');
        $totalPending = $payments->where('status', 'pending')->sum('amount');
        $totalRejected = $payments->where('status', 'rejected')->sum('amount');

        return view('reports.payment-result', compact(
            'payments',
            'totalPayments',
            'totalAmount',
            'totalVerified',
            'totalPending',
            'totalRejected',
            'validated'
        ));
    }

    /**
     * Export payment report to PDF
     */
    public function paymentPdf(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'nullable|in:pending,verified,rejected',
        ]);

        $query = Payment::with(['invoice.customer', 'invoice.salesOrder'])
            ->whereBetween('payment_date', [$validated['start_date'], $validated['end_date']]);

        if (!empty($validated['customer_id'])) {
            $query->whereHas('invoice', function($q) use ($validated) {
                $q->where('customer_id', $validated['customer_id']);
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        $totalPayments = $payments->count();
        $totalAmount = $payments->sum('amount');
        $totalVerified = $payments->where('status', 'verified')->sum('amount');
        $totalPending = $payments->where('status', 'pending')->sum('amount');
        $totalRejected = $payments->where('status', 'rejected')->sum('amount');

        $customerName = !empty($validated['customer_id']) ? Customer::find($validated['customer_id'])->name : 'Semua Customer';
        $statusText = !empty($validated['status']) ? ucfirst($validated['status']) : 'Semua Status';

        $pdf = PDF::loadView('reports.payment-pdf', compact(
            'payments',
            'totalPayments',
            'totalAmount',
            'totalVerified',
            'totalPending',
            'totalRejected',
            'validated',
            'customerName',
            'statusText'
        ));

        return $pdf->download('laporan-pembayaran-' . now()->format('Ymd-His') . '.pdf');
    }
}
