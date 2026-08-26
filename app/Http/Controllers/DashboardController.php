<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Brand;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\WarehouseStock;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Get realtime dashboard data
     */
    public function realtimeData()
    {
        $user = auth()->user();
        $data = [];

        if ($user->hasRole('admin')) {
            $data = [
                'statistics' => [
                    'categories' => Category::count(),
                    'suppliers' => Supplier::count(),
                    'warehouses' => Warehouse::count(),
                    'brands' => Brand::count(),
                ],
                'sales_data' => $this->getSalesData(),
                'category_data' => $this->getCategoryData(),
                'recent_categories' => Category::take(5)->get()->map(function ($category) {
                    return [
                        'name' => $category->name,
                        'product_count' => $category->products()->count(),
                        'is_active' => $category->is_active,
                    ];
                }),
                'recent_suppliers' => Supplier::take(5)->get()->map(function ($supplier) {
                    return [
                        'name' => $supplier->name,
                        'city' => $supplier->city ?? '-',
                        'is_active' => $supplier->is_active,
                    ];
                }),
            ];
        } elseif ($user->hasRole('sales')) {
            $data = [
                'statistics' => [
                    'target_sales' => 50000000,
                    'target_achieved' => 65,
                    'total_orders' => SalesOrder::where('sales_id', $user->id)->count(),
                    'commission' => 0,
                ],
                'sales_performance' => $this->getSalesPerformanceData($user->id),
                'order_status' => $this->getOrderStatusData($user->id),
            ];
        } elseif ($user->hasRole('admin_gudang')) {
            $data = [
                'statistics' => [
                    'warehouses' => Warehouse::count(),
                    'low_stock' => WarehouseStock::where('quantity', '<=', function($query) {
                        $query->select('minimum_stock')->from('products')->whereColumn('products.id', 'warehouse_stocks.product_id');
                    })->count(),
                    'pending_orders' => SalesOrder::whereIn('status', ['confirmed', 'payment_verified'])->count(),
                    'stock_movements' => 0,
                ],
                'warehouse_status' => $this->getWarehouseStatusData(),
                'warehouses' => Warehouse::take(5)->get()->map(function ($warehouse) {
                    return [
                        'code' => $warehouse->code,
                        'name' => $warehouse->name,
                        'city' => $warehouse->city ?? '-',
                        'is_active' => $warehouse->is_active,
                    ];
                }),
            ];
        } elseif ($user->hasRole('finance')) {
            $data = [
                'statistics' => [
                    'total_invoices' => Invoice::count(),
                    'overdue' => Invoice::where('payment_status', 'overdue')->count(),
                    'total_receivable' => Invoice::where('payment_status', '!=', 'paid')->sum('remaining_amount'),
                    'payments_received' => Payment::where('status', 'verified')->sum('amount'),
                ],
                'cash_flow' => $this->getCashFlowData(),
                'payment_status' => $this->getPaymentStatusData(),
            ];
        } elseif ($user->hasRole('customer')) {
            $data = [
                'statistics' => [
                    'total_orders' => SalesOrder::where('customer_id', $user->id)->count(),
                    'active_orders' => SalesOrder::where('customer_id', $user->id)
                        ->whereIn('status', ['confirmed', 'processing', 'packing', 'ready_to_ship', 'shipped', 'in_transit'])
                        ->count(),
                    'total_bills' => Invoice::where('customer_id', $user->id)->sum('remaining_amount'),
                ],
                'order_history' => $this->getCustomerOrderHistory($user->id),
                'order_status' => $this->getCustomerOrderStatus($user->id),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get sales data for admin chart
     */
    private function getSalesData()
    {
        // Simulated data - in real app, query from SalesOrder or Sales model
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [12, 19, 15, 25, 22, 30, 28, 35, 20, 25, 30, 40],
        ];
    }

    /**
     * Get category distribution data
     */
    private function getCategoryData()
    {
        $categories = Category::withCount('products')->take(5)->get();
        return [
            'labels' => $categories->pluck('name'),
            'data' => $categories->pluck('products_count'),
        ];
    }

    /**
     * Get sales performance data for sales user
     */
    private function getSalesPerformanceData($salesId)
    {
        // Simulated data - in real app, query from SalesOrder
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [15, 20, 18, 25, 22, 30],
        ];
    }

    /**
     * Get order status data for sales user
     */
    private function getOrderStatusData($salesId)
    {
        $orders = SalesOrder::where('sales_id', $salesId);
        return [
            'labels' => ['Pending', 'Confirmed', 'Shipped', 'Delivered'],
            'data' => [
                $orders->where('status', 'pending_confirmation')->count(),
                $orders->where('status', 'confirmed')->count(),
                $orders->where('status', 'shipped')->count(),
                $orders->where('status', 'delivered')->count(),
            ],
        ];
    }

    /**
     * Get warehouse status data
     */
    private function getWarehouseStatusData()
    {
        $warehouses = Warehouse::withCount('warehouseStocks')->get();
        return [
            'labels' => $warehouses->pluck('name'),
            'data' => $warehouses->map(function ($warehouse) {
                // Calculate capacity percentage (simulated)
                return rand(40, 90);
            }),
        ];
    }

    /**
     * Get cash flow data for finance
     */
    private function getCashFlowData()
    {
        // Simulated data - in real app, query from Payment and Invoice
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'income' => [50, 60, 55, 70, 65, 80],
            'expense' => [30, 35, 32, 40, 38, 45],
        ];
    }

    /**
     * Get payment status data for finance
     */
    private function getPaymentStatusData()
    {
        $invoices = Invoice::all();
        return [
            'labels' => ['Lunas', 'Pending', 'Jatuh Tempo'],
            'data' => [
                $invoices->where('payment_status', 'paid')->count(),
                $invoices->where('payment_status', 'partial')->count(),
                $invoices->where('payment_status', 'overdue')->count(),
            ],
        ];
    }

    /**
     * Get customer order history
     */
    private function getCustomerOrderHistory($customerId)
    {
        // Simulated data - in real app, query from SalesOrder
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [5, 8, 6, 10, 7, 12],
        ];
    }

    /**
     * Get customer order status
     */
    private function getCustomerOrderStatus($customerId)
    {
        $orders = SalesOrder::where('customer_id', $customerId);
        return [
            'labels' => ['Sedang Diproses', 'Dikirim', 'Selesai'],
            'data' => [
                $orders->whereIn('status', ['confirmed', 'processing', 'packing'])->count(),
                $orders->whereIn('status', ['shipped', 'in_transit'])->count(),
                $orders->where('status', 'delivered')->count(),
            ],
        ];
    }
}
