<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WarehouseStockController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentTrackingController;
use App\Http\Controllers\AccountsReceivableController;
use App\Http\Controllers\PaymentReminderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CartController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Route (Protected)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
Route::get('/dashboard/realtime', [DashboardController::class, 'realtimeData'])
    ->middleware(['auth'])
    ->name('dashboard.realtime');

// Categories Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('warehouses', WarehouseController::class);
    // Product Routes
    Route::resource('products', ProductController::class);
    Route::get('/products/scanner', [ProductController::class, 'scanner'])->name('products.scanner');
    Route::post('/products/scan-barcode', [ProductController::class, 'scanBarcode'])->name('products.scan-barcode');
    Route::resource('customers', CustomerController::class);
    Route::resource('warehouse-stocks', WarehouseStockController::class);
    Route::post('/warehouse-stocks/add-stock', [WarehouseStockController::class, 'addStock'])->name('warehouse-stocks.add-stock');
    Route::resource('stock-movements', StockMovementController::class);
    Route::resource('sales-orders', SalesOrderController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('payments', PaymentController::class);
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    Route::resource('shipments', ShipmentController::class);
    Route::post('/shipments/{shipment}/tracking', [ShipmentController::class, 'updateTracking'])->name('shipments.update-tracking');
    Route::get('/shipments/{shipment}/tracking', [ShipmentController::class, 'getTracking'])->name('shipments.get-tracking');
    Route::resource('shipment-tracking', ShipmentTrackingController::class);
    Route::get('/shipment-tracking/realtime/{shipment}', [ShipmentTrackingController::class, 'getRealtimeTracking'])->name('shipment-tracking.realtime');
    Route::get('/accounts-receivable', [AccountsReceivableController::class, 'index'])->name('accounts-receivable.index');
    Route::get('/accounts-receivable/create', [AccountsReceivableController::class, 'create'])->name('accounts-receivable.create');
    Route::post('/accounts-receivable', [AccountsReceivableController::class, 'store'])->name('accounts-receivable.store');
    Route::get('/accounts-receivable/{id}', [AccountsReceivableController::class, 'show'])->name('accounts-receivable.show');
    Route::get('/accounts-receivable/{id}/edit', [AccountsReceivableController::class, 'edit'])->name('accounts-receivable.edit');
    Route::put('/accounts-receivable/{id}', [AccountsReceivableController::class, 'update'])->name('accounts-receivable.update');
    Route::delete('/accounts-receivable/{id}', [AccountsReceivableController::class, 'destroy'])->name('accounts-receivable.destroy');
    Route::get('/accounts-receivable/realtime', [AccountsReceivableController::class, 'getRealtimeData'])->name('accounts-receivable.realtime');
    Route::get('/accounts-receivable/{id}/receivable', [AccountsReceivableController::class, 'getCustomerReceivable'])->name('accounts-receivable.customer');
    
    Route::get('/payment-reminders', [PaymentReminderController::class, 'index'])->name('payment-reminders.index');
    Route::get('/payment-reminders/create', [PaymentReminderController::class, 'create'])->name('payment-reminders.create');
    Route::post('/payment-reminders', [PaymentReminderController::class, 'store'])->name('payment-reminders.store');
    Route::get('/payment-reminders/{id}', [PaymentReminderController::class, 'show'])->name('payment-reminders.show');
    Route::get('/payment-reminders/{id}/edit', [PaymentReminderController::class, 'edit'])->name('payment-reminders.edit');
    Route::put('/payment-reminders/{id}', [PaymentReminderController::class, 'update'])->name('payment-reminders.update');
    Route::delete('/payment-reminders/{id}', [PaymentReminderController::class, 'destroy'])->name('payment-reminders.destroy');
    Route::post('/payment-reminders/bulk', [PaymentReminderController::class, 'sendBulkReminders'])->name('payment-reminders.bulk');
    Route::get('/payment-reminders/realtime', [PaymentReminderController::class, 'getRealtimeData'])->name('payment-reminders.realtime');
    
    // Report Routes
    Route::get('/reports/sales', [ReportController::class, 'salesIndex'])->name('reports.sales.index');
    Route::get('/reports/sales/generate', [ReportController::class, 'salesGenerate'])->name('reports.sales.generate');
    Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('/reports/stock', [ReportController::class, 'stockIndex'])->name('reports.stock.index');
    Route::get('/reports/stock/generate', [ReportController::class, 'stockGenerate'])->name('reports.stock.generate');
    Route::get('/reports/stock/pdf', [ReportController::class, 'stockPdf'])->name('reports.stock.pdf');
    Route::get('/reports/payment', [ReportController::class, 'paymentIndex'])->name('reports.payment.index');
    Route::get('/reports/payment/generate', [ReportController::class, 'paymentGenerate'])->name('reports.payment.generate');
    Route::get('/reports/payment/pdf', [ReportController::class, 'paymentPdf'])->name('reports.payment.pdf');
    
    // System Routes
    Route::resource('users', UserController::class);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Cart Routes (Customer only)
    Route::prefix('cart')->middleware(['auth', 'role:customer'])->group(function () {
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('/view', [CartController::class, 'view'])->name('cart.view');
        Route::put('/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
    });
    
    // Customer Routes
    Route::prefix('customer')->middleware(['auth', 'role:customer'])->group(function () {
        Route::get('/catalog', [CustomerController::class, 'catalog'])->name('customer.catalog');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
        Route::get('/orders/{salesOrder}', [CustomerController::class, 'orderDetail'])->name('customer.orders.show');
        Route::get('/invoices', [CustomerController::class, 'invoices'])->name('customer.invoices');
        Route::get('/shipments', [CustomerController::class, 'shipments'])->name('customer.shipments');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    });
    Route::resource('roles', RoleController::class);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/user', [NotificationController::class, 'getUserNotifications'])->name('notifications.user');
    Route::post('/notifications/{notification}/mark-read-ajax', [NotificationController::class, 'markAsReadAjax'])->name('notifications.mark-read-ajax');
    Route::post('/notifications/mark-all-read-ajax', [NotificationController::class, 'markAllAsReadAjax'])->name('notifications.mark-all-read-ajax');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::get('/audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [SettingsController::class, 'reset'])->name('settings.reset');
});

// Home Route
Route::get('/', function () {
    return redirect()->route('login');
});
