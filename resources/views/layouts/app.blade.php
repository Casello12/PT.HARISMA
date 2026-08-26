<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Informasi Manajemen Stok - PT. Kharisma Sukses Persada')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #16A34A;
            --dark-green: #15803D;
            --light-green: #DCFCE7;
            --primary-blue: #2563EB;
            --dark-blue: #1D4ED8;
            --light-blue: #DBEAFE;
            --white: #FFFFFF;
            --background: #F8FAFC;
            --text-color: #1E293B;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
        }
        
        body {
            background-color: var(--background);
            color: var(--text-color);
        }
        
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-green) 0%, var(--dark-green) 100%);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .sidebar-submenu,
        .sidebar.collapsed .bi-chevron-down,
        .sidebar.collapsed .sidebar-footer {
            display: none;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand {
            color: var(--white);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: opacity 0.2s ease;
        }
        
        .sidebar-brand:hover {
            opacity: 0.9;
        }
        
        .sidebar-brand i {
            font-size: 1.5rem;
            line-height: 1;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
            overflow-y: auto;
            flex: 1;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu-item {
            margin-bottom: 0.5rem;
        }
        
        .sidebar-menu-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            margin: 0.25rem 0.5rem;
            min-height: 44px;
        }
        
        .sidebar-menu-link:hover,
        .sidebar-menu-link.active {
            background: rgba(255,255,255,0.15);
            color: var(--white);
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .sidebar-menu-link i.icon-main {
            font-size: 1.25rem;
            width: 1.5rem;
            text-align: center;
            line-height: 1;
        }
        
        .sidebar-menu-link i.bi-chevron-down,
        .sidebar-menu-link i.bi-chevron-up {
            font-size: 0.875rem;
            transition: transform 0.3s ease;
            line-height: 1;
        }
        
        .sidebar-menu-link i.bi-chevron-up {
            transform: rotate(180deg);
        }
        
        .sidebar-submenu {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-left: 1rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.3s ease;
            opacity: 0;
        }
        
        .sidebar-submenu.show {
            max-height: 500px;
            opacity: 1;
            margin-top: 0.25rem;
        }
        
        .sidebar-submenu-item {
            margin-bottom: 0.25rem;
        }
        
        .sidebar-submenu-link {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 0.625rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            margin: 0.125rem 0.5rem;
        }
        
        .sidebar-submenu-link i {
            font-size: 1rem;
            line-height: 1;
            width: 1.25rem;
            text-align: center;
        }
        
        .sidebar-submenu-link:hover,
        .sidebar-submenu-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            font-weight: 600;
            transform: translateX(3px);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        .top-bar {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .sidebar-toggle {
            background: var(--light-green);
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            color: var(--dark-green);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-toggle i {
            line-height: 1;
        }
        
        .sidebar-toggle:hover {
            background: var(--primary-green);
            color: white;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #DC2626;
            color: white;
            font-size: 0.65rem;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }
        
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.75rem;
        }
        
        .content-wrapper {
            animation: fadeIn 0.3s ease;
        }
        
        /* Global Icon Styling */
        i {
            vertical-align: middle;
            line-height: 1;
            display: inline-block;
        }
        
        .btn i {
            line-height: 1;
        }
        
        .badge i {
            line-height: 1;
        }
        
        .table i {
            line-height: 1;
        }
        
        .card-header i {
            line-height: 1;
        }
        
        .form-check i {
            line-height: 1;
        }
        
        .dropdown-toggle i {
            line-height: 1;
        }
        
        .nav-link i {
            line-height: 1;
        }
        
        /* Icon Container for consistency */
        .icon-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--light-green);
            color: var(--dark-green);
        }
        
        .icon-container i {
            font-size: 1rem;
            line-height: 1;
        }
        
        /* Button Icon Spacing */
        .btn i {
            margin-right: 0.5rem;
        }
        
        .btn i:last-child {
            margin-right: 0;
        }
        
        .btn i:first-child {
            margin-left: 0;
        }
        
        /* Fix icon alignment in specific contexts */
        .sidebar-menu-link i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-submenu-link i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .top-bar i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .table .btn i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .barcode-container {
            background: white;
            padding: 10px;
            border-radius: 4px;
            display: inline-block;
            border: 1px solid #ddd;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .top-bar {
                padding: 0.75rem 1rem;
                margin-bottom: 1rem;
            }
        }
    </style>
    
    @vite(['resources/css/app.css'])
</head>
<body>
    @auth
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <i class="bi bi-box-seam"></i>
                    <span class="brand-text">PT. Kharisma</span>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-menu-link @if(request()->is('dashboard')) active @endif">
                            <i class="bi bi-speedometer2 icon-main"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    
                    @role('admin')
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="masterDataMenu">
                                <i class="bi bi-grid icon-main"></i>
                                <span class="menu-text">Master Data</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="masterDataMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('products.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-box"></i> Produk
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('categories.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-tags"></i> Kategori
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('brands.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-tag"></i> Brand
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('customers.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-people"></i> Customer
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('suppliers.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-building"></i> Supplier
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('warehouses.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-house"></i> Gudang
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="inventoryMenu">
                                <i class="bi bi-box-seam icon-main"></i>
                                <span class="menu-text">Inventory</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="inventoryMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('warehouse-stocks.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-box"></i> Stok Gudang
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('stock-movements.index') }}" class="sidebar-submenu-link">
                                        <i class="bi bi-arrow-left-right"></i> Pergerakan Stok
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="transactionMenu">
                                <i class="bi bi-cart icon-main"></i>
                                <span class="menu-text">Transaksi</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="transactionMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('sales-orders.index') }}" class="sidebar-submenu-link @if(request()->is('sales-orders*')) active @endif">
                                        <i class="bi bi-cart"></i> Sales Order
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('invoices.index') }}" class="sidebar-submenu-link @if(request()->is('invoices*')) active @endif">
                                        <i class="bi bi-file-earmark-text"></i> Invoice
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('payments.index') }}" class="sidebar-submenu-link @if(request()->is('payments*')) active @endif">
                                        <i class="bi bi-currency-dollar"></i> Pembayaran
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="distributionMenu">
                                <i class="bi bi-truck icon-main"></i>
                                <span class="menu-text">Distribusi</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="distributionMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('shipments.index') }}" class="sidebar-submenu-link @if(request()->is('shipments*')) active @endif">
                                        <i class="bi bi-truck"></i> Pengiriman
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('shipment-tracking.index') }}" class="sidebar-submenu-link @if(request()->is('shipment-tracking*')) active @endif">
                                        <i class="bi bi-geo-alt"></i> Tracking
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="financeMenu">
                                <i class="bi bi-currency-dollar icon-main"></i>
                                <span class="menu-text">Finance</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="financeMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('accounts-receivable.index') }}" class="sidebar-submenu-link @if(request()->is('accounts-receivable*')) active @endif">
                                        <i class="bi bi-wallet2"></i> Piutang
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('payment-reminders.index') }}" class="sidebar-submenu-link @if(request()->is('payment-reminders*')) active @endif">
                                        <i class="bi bi-bell"></i> Pengingat Pembayaran
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="reportMenu">
                                <i class="bi bi-file-earmark-bar-graph icon-main"></i>
                                <span class="menu-text">Laporan</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="reportMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('reports.sales.index') }}" class="sidebar-submenu-link @if(request()->is('reports/sales*')) active @endif">
                                        <i class="bi bi-graph-up"></i> Laporan Penjualan
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('reports.stock.index') }}" class="sidebar-submenu-link @if(request()->is('reports/stock*')) active @endif">
                                        <i class="bi bi-box-seam"></i> Laporan Stok
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('reports.payment.index') }}" class="sidebar-submenu-link @if(request()->is('reports/payment*')) active @endif">
                                        <i class="bi bi-currency-dollar"></i> Laporan Pembayaran
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a href="#" class="sidebar-menu-link has-submenu" data-submenu="systemMenu">
                                <i class="bi bi-gear icon-main"></i>
                                <span class="menu-text">Sistem</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul class="sidebar-submenu" id="systemMenu">
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('users.index') }}" class="sidebar-submenu-link @if(request()->is('users*')) active @endif">
                                        <i class="bi bi-people"></i> Users
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('roles.index') }}" class="sidebar-submenu-link @if(request()->is('roles*')) active @endif">
                                        <i class="bi bi-shield-lock"></i> Roles
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('notifications.index') }}" class="sidebar-submenu-link @if(request()->is('notifications*')) active @endif">
                                        <i class="bi bi-bell"></i> Notifikasi
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('audit-logs.index') }}" class="sidebar-submenu-link @if(request()->is('audit-logs*')) active @endif">
                                        <i class="bi bi-clock-history"></i> Audit Log
                                    </a>
                                </li>
                                <li class="sidebar-submenu-item">
                                    <a href="{{ route('settings.index') }}" class="sidebar-submenu-link @if(request()->is('settings*')) active @endif">
                                        <i class="bi bi-sliders"></i> Pengaturan
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endrole
                    
                    @role('sales')
                        <li class="sidebar-menu-item">
                            <a href="{{ route('products.index') }}" class="sidebar-menu-link">
                                <i class="bi bi-box icon-main"></i>
                                <span class="menu-text">Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('products.scanner') }}" class="sidebar-menu-link @if(request()->is('products/scanner')) active @endif">
                                <i class="bi bi-upc-scan icon-main"></i>
                                <span class="menu-text">Barcode Scanner</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('sales-orders.index') }}" class="sidebar-menu-link @if(request()->is('sales-orders*')) active @endif">
                                <i class="bi bi-cart icon-main"></i>
                                <span class="menu-text">Sales Order</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('invoices.index') }}" class="sidebar-menu-link @if(request()->is('invoices*')) active @endif">
                                <i class="bi bi-file-earmark-text icon-main"></i>
                                <span class="menu-text">Invoice</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('payments.index') }}" class="sidebar-menu-link @if(request()->is('payments*')) active @endif">
                                <i class="bi bi-currency-dollar icon-main"></i>
                                <span class="menu-text">Pembayaran</span>
                            </a>
                        </li>
                    @endrole
                    
                    @role('admin_gudang')
                        <li class="sidebar-menu-item">
                            <a href="{{ route('warehouse-stocks.index') }}" class="sidebar-menu-link">
                                <i class="bi bi-box-seam icon-main"></i>
                                <span class="menu-text">Stok</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('stock-movements.index') }}" class="sidebar-menu-link">
                                <i class="bi bi-arrow-left-right icon-main"></i>
                                <span class="menu-text">Pergerakan Stok</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('shipments.index') }}" class="sidebar-menu-link @if(request()->is('shipments*')) active @endif">
                                <i class="bi bi-truck icon-main"></i>
                                <span class="menu-text">Pengiriman</span>
                            </a>
                        </li>
                    @endrole
                    
                    @role('finance')
                        <li class="sidebar-menu-item">
                            <a href="{{ route('invoices.index') }}" class="sidebar-menu-link @if(request()->is('invoices*')) active @endif">
                                <i class="bi bi-file-earmark-text icon-main"></i>
                                <span class="menu-text">Invoice</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('payments.index') }}" class="sidebar-menu-link @if(request()->is('payments*')) active @endif">
                                <i class="bi bi-currency-dollar icon-main"></i>
                                <span class="menu-text">Pembayaran</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('accounts-receivable.index') }}" class="sidebar-menu-link @if(request()->is('accounts-receivable*')) active @endif">
                                <i class="bi bi-wallet2 icon-main"></i>
                                <span class="menu-text">Piutang</span>
                            </a>
                        </li>
                    @endrole
                    
                    @role('customer')
                        <li class="sidebar-menu-item">
                            <a href="{{ route('customer.catalog') }}" class="sidebar-menu-link @if(request()->is('customer/catalog*')) active @endif">
                                <i class="bi bi-grid icon-main"></i>
                                <span class="menu-text">Katalog Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('cart.view') }}" class="sidebar-menu-link @if(request()->is('cart*')) active @endif">
                                <i class="bi bi-cart icon-main"></i>
                                <span class="menu-text">Keranjang</span>
                                <span class="badge bg-success rounded-pill cart-badge d-none">0</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('customer.orders') }}" class="sidebar-menu-link @if(request()->is('customer/orders*')) active @endif">
                                <i class="bi bi-receipt icon-main"></i>
                                <span class="menu-text">Pesanan Saya</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('customer.invoices') }}" class="sidebar-menu-link @if(request()->is('customer/invoices*')) active @endif">
                                <i class="bi bi-file-earmark-text icon-main"></i>
                                <span class="menu-text">Invoice</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('customer.shipments') }}" class="sidebar-menu-link @if(request()->is('customer/shipments*')) active @endif">
                                <i class="bi bi-truck icon-main"></i>
                                <span class="menu-text">Tracking</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('customer.profile') }}" class="sidebar-menu-link @if(request()->is('customer/profile*')) active @endif">
                                <i class="bi bi-person icon-main"></i>
                                <span class="menu-text">Profil Saya</span>
                            </a>
                        </li>
                    @endrole
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <p>&copy; 2026 PT. Kharisma Sukses Persada</p>
            </div>
        </div>
        
        <div class="main-content" id="mainContent">
            <div class="top-bar">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="d-flex align-items-center gap-3">
                    @role('customer')
                        <a href="{{ route('cart.view') }}" class="nav-link position-relative me-2">
                            <i class="bi bi-cart" style="font-size: 1.25rem; line-height: 1;">
                                <span class="notification-badge bg-success cart-badge d-none" id="cartBadge">0</span>
                            </i>
                        </a>
                    @endrole
                    
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" data-bs-toggle="dropdown" position="dropend" id="notificationDropdown">
                            <i class="bi bi-bell" style="font-size: 1.25rem; line-height: 1;">
                                <span class="notification-badge" id="notificationBadge">0</span>
                            </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0" style="width: 350px; max-height: 400px; overflow-y: auto;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center bg-light">
                                <span class="fw-semibold">Notifikasi</span>
                                <button class="btn btn-sm btn-link text-decoration-none p-0" id="markAllReadBtn">
                                    <small>Tandai semua dibaca</small>
                                </button>
                            </li>
                            <li id="notificationList">
                                <div class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-center fw-semibold" href="{{ route('notifications.index') }}">
                                    Lihat Semua Notifikasi
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" position="dropend">
                            <i class="bi bi-person-circle"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="bi bi-person"></i> Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    @else
        @yield('content')
    @endauth
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Make jQuery available globally for backward compatibility
    if (typeof jQuery === 'undefined') {
        console.warn('jQuery is not loaded');
    }
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContent = document.getElementById('mainContent');
            
            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                
                // On mobile, show/hide sidebar
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                }
            });
            
            // Handle submenu toggles
            const submenuToggles = document.querySelectorAll('.has-submenu');
            submenuToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenuId = this.getAttribute('data-submenu');
                    const submenu = document.getElementById(submenuId);
                    const chevron = this.querySelector('.bi-chevron-down, .bi-chevron-up');
                    
                    // Close all other submenus
                    document.querySelectorAll('.sidebar-submenu.show').forEach(function(otherSubmenu) {
                        if (otherSubmenu.id !== submenuId) {
                            otherSubmenu.classList.remove('show');
                            const otherChevron = otherSubmenu.previousElementSibling.querySelector('.bi-chevron-up');
                            if (otherChevron) {
                                otherChevron.classList.remove('bi-chevron-up');
                                otherChevron.classList.add('bi-chevron-down');
                            }
                        }
                    });
                    
                    // Toggle current submenu
                    if (submenu.classList.contains('show')) {
                        submenu.classList.remove('show');
                        if (chevron) {
                            chevron.classList.remove('bi-chevron-up');
                            chevron.classList.add('bi-chevron-down');
                        }
                    } else {
                        submenu.classList.add('show');
                        if (chevron) {
                            chevron.classList.remove('bi-chevron-down');
                            chevron.classList.add('bi-chevron-up');
                        }
                    }
                });
            });
            
            // Active menu highlight
            const currentPath = window.location.pathname;
            
            // Highlight main menu links
            const menuLinks = document.querySelectorAll('.sidebar-menu-link:not(.has-submenu)');
            menuLinks.forEach(function(link) {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Highlight submenu links and keep parent submenu open
            const submenuLinks = document.querySelectorAll('.sidebar-submenu-link');
            submenuLinks.forEach(function(link) {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    
                    // Open parent submenu
                    const parentSubmenu = link.closest('.sidebar-submenu');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('show');
                        
                        // Update chevron
                        const parentToggle = parentSubmenu.previousElementSibling;
                        const chevron = parentToggle.querySelector('.bi-chevron-down, .bi-chevron-up');
                        if (chevron) {
                            chevron.classList.remove('bi-chevron-down');
                            chevron.classList.add('bi-chevron-up');
                        }
                    }
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                }
            });
            
            // Notification System
            const notificationBadge = document.getElementById('notificationBadge');
            const notificationList = document.getElementById('notificationList');
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            const notificationDropdown = document.getElementById('notificationDropdown');
            
            // Fetch user notifications
            function fetchNotifications() {
                fetch('/notifications/user')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateNotificationBadge(data.unread_count);
                            renderNotifications(data.notifications);
                        }
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }
            
            // Update notification badge
            function updateNotificationBadge(count) {
                if (notificationBadge) {
                    notificationBadge.textContent = count;
                    if (count > 0) {
                        notificationBadge.style.display = 'inline-block';
                    } else {
                        notificationBadge.style.display = 'none';
                    }
                }
            }
            
            // Render notifications in dropdown
            function renderNotifications(notifications) {
                if (!notificationList) return;
                
                if (notifications.length === 0) {
                    notificationList.innerHTML = `
                        <div class="text-center py-4">
                            <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0 mt-2">Tidak ada notifikasi</p>
                        </div>
                    `;
                    return;
                }
                
                let html = '';
                notifications.forEach(notification => {
                    const isUnread = notification.read_status === 'unread';
                    const bgClass = isUnread ? 'bg-light' : '';
                    const fwClass = isUnread ? 'fw-semibold' : '';
                    const timeAgo = getTimeAgo(notification.created_at);
                    
                    html += `
                        <a href="${notification.link || '#'}" 
                           class="dropdown-item d-flex align-items-start gap-2 py-3 px-3 ${bgClass} border-bottom"
                           data-notification-id="${notification.id}"
                           onclick="markAsRead(event, ${notification.id})">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="bi bi-bell" style="font-size: 0.875rem; line-height: 1;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 ${fwClass}" style="font-size: 0.875rem;">${notification.title}</p>
                                <p class="mb-1 text-muted" style="font-size: 0.75rem;">${notification.message}</p>
                                <small class="text-muted" style="font-size: 0.7rem;">${timeAgo}</small>
                            </div>
                            ${isUnread ? '<div class="flex-shrink-0"><span class="badge bg-success rounded-circle" style="width: 8px; height: 8px; padding: 0;"></span></div>' : ''}
                        </a>
                    `;
                });
                
                notificationList.innerHTML = html;
            }
            
            // Mark notification as read
            window.markAsRead = function(event, notificationId) {
                event.preventDefault();
                
                fetch(`/notifications/${notificationId}/mark-read-ajax`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateNotificationBadge(data.unread_count);
                        fetchNotifications();
                        
                        // Navigate to link if exists
                        const link = event.target.closest('a');
                        if (link && link.getAttribute('href') !== '#') {
                            window.location.href = link.getAttribute('href');
                        }
                    }
                })
                .catch(error => console.error('Error marking notification as read:', error));
            }
            
            // Mark all notifications as read
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    fetch('/notifications/mark-all-read-ajax', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateNotificationBadge(data.unread_count);
                            fetchNotifications();
                        }
                    })
                    .catch(error => console.error('Error marking all notifications as read:', error));
                });
            }
            
            // Get time ago string
            function getTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);
                
                if (seconds < 60) {
                    return 'Baru saja';
                } else if (seconds < 3600) {
                    const minutes = Math.floor(seconds / 60);
                    return `${minutes} menit yang lalu`;
                } else if (seconds < 86400) {
                    const hours = Math.floor(seconds / 3600);
                    return `${hours} jam yang lalu`;
                } else if (seconds < 604800) {
                    const days = Math.floor(seconds / 86400);
                    return `${days} hari yang lalu`;
                } else {
                    return date.toLocaleDateString('id-ID');
                }
            }
            
            // Initial fetch
            fetchNotifications();
            
            // Refresh notifications every 30 seconds
            setInterval(fetchNotifications, 30000);
            
            // Refresh when dropdown is opened
            if (notificationDropdown) {
                notificationDropdown.addEventListener('click', function() {
                    fetchNotifications();
                });
            }
            
            // Cart System (for customer role)
            @if(auth()->check() && auth()->user()->hasRole('customer'))
                const cartBadge = document.getElementById('cartBadge');
                
                // Fetch cart items
                function fetchCart() {
                    fetch('{{ route("cart.index") }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateCartBadge(data.total_quantity);
                            }
                        })
                        .catch(error => console.error('Error fetching cart:', error));
                }
                
                // Update cart badge
                function updateCartBadge(count) {
                    if (cartBadge) {
                        cartBadge.textContent = count;
                        if (count > 0) {
                            cartBadge.style.display = 'inline-block';
                            cartBadge.classList.remove('d-none');
                        } else {
                            cartBadge.style.display = 'none';
                            cartBadge.classList.add('d-none');
                        }
                    }
                    
                    // Also update sidebar cart badge
                    document.querySelectorAll('.cart-badge').forEach(badge => {
                        badge.textContent = count;
                        if (count > 0) {
                            badge.classList.remove('d-none');
                            badge.style.display = 'inline-block';
                        } else {
                            badge.classList.add('d-none');
                            badge.style.display = 'none';
                        }
                    });
                }
                
                // Initial fetch
                fetchCart();
                
                // Refresh cart every 30 seconds
                setInterval(fetchCart, 30000);
            @endif
        });
    </script>
    
    @vite(['resources/js/app.js'])
    
    @stack('scripts')
</body>
</html>