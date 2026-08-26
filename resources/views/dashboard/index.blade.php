@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-1 fw-bold">
                        <i class="bi bi-speedometer2 me-2 text-success"></i>
                        Dashboard
                    </h1>
                    <p class="text-muted mb-0">Selamat datang, <span class="fw-semibold">{{ auth()->user()->name }}</span>!</p>
                </div>
                <div class="text-end">
                    <div class="badge bg-light text-dark border">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ now()->format('l, d F Y') }}
                    </div>
                    <div class="badge bg-light text-dark border mt-1">
                        <i class="bi bi-clock me-1"></i>
                        {{ now()->format('H:i') }} WIB
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @role('admin')
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Produk</p>
                                <h3 class="mb-0 fw-bold">{{ \App\Models\Category::count() }} Kategori</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +12% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-box-seam style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Supplier</p>
                                <h3 class="mb-0 fw-bold">{{ \App\Models\Supplier::count() }}</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +5% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-building style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Gudang</p>
                                <h3 class="mb-0 fw-bold">{{ \App\Models\Warehouse::count() }}</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +2% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-house style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Brand</p>
                                <h3 class="mb-0 fw-bold">{{ \App\Models\Brand::count() }}</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +8% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-tag style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Statistik Penjualan Bulanan</h5>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary active">Tahun Ini</button>
                                <button class="btn btn-sm btn-outline-primary">Bulan Ini</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Distribusi Produk</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tables Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Kategori Terpopuler</h5>
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-center">Jumlah Produk</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Category::take(5)->get() as $category)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-grid" style="font-size: 1rem; line-height: 1;"></i>
                                                </div>
                                                <span class="fw-medium">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">{{ $category->products()->count() }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($category->is_active)
                                                <span class="badge bg-success-subtle text-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Supplier Terbaru</h5>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Kota</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Supplier::take(5)->get() as $supplier)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-building" style="font-size: 1rem; line-height: 1;"></i>
                                                </div>
                                                <span class="fw-medium">{{ $supplier->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $supplier->city ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($supplier->is_active)
                                                <span class="badge bg-success-subtle text-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Aktivitas Terbaru</h5>
                            <button class="btn btn-sm btn-outline-primary">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1 fw-semibold">Sistem diinisialisasi</h6>
                                        <small class="text-muted">Baru saja</small>
                                    </div>
                                    <p class="text-muted mb-0 small">Dashboard admin telah berhasil dibuat dengan fitur lengkap.</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1 fw-semibold">Master Data dibuat</h6>
                                        <small class="text-muted">Beberapa menit yang lalu</small>
                                    </div>
                                    <p class="text-muted mb-0 small">CRUD untuk Kategori, Brand, Supplier, dan Gudang telah selesai dibuat.</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1 fw-semibold">User sistem dibuat</h6>
                                        <small class="text-muted">Beberapa jam yang lalu</small>
                                    </div>
                                    <p class="text-muted mb-0 small">5 user dengan role berbeda telah dibuat untuk testing sistem.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    
    @role('sales')
        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Target Penjualan</p>
                                <h3 class="mb-0 fw-bold">Rp 50.000.000</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-trophy-fill me-1"></i> 65% tercapai
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-currency-dollar style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Order</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +15% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-cart style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Komisi Bulan Ini</p>
                                <h3 class="mb-0 fw-bold">Rp 0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +10% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-percent style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Performa Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesPerformanceChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Status Order</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="orderStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    
    @role('admin_gudang')
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Gudang</p>
                                <h3 class="mb-0 fw-bold">{{ \App\Models\Warehouse::count() }}</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Semua aktif
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-house style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Stok Menipis</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Perlu restock
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-box-seam style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Order Pending</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-clock-fill me-1"></i> Perlu diproses
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-truck style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Stock Movement</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-left-right me-1"></i> Hari ini
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-graph-up style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Status Gudang</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="warehouseStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Gudang</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Warehouse::take(5)->get() as $warehouse)
                                    <tr>
                                        <td><code>{{ $warehouse->code }}</code></td>
                                        <td class="fw-medium">{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->city ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($warehouse->is_active)
                                                <span class="badge bg-success-subtle text-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    
    @role('finance')
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Invoice</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +20% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-file-earmark-text style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Jatuh Tempo</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Perlu follow-up
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-clock style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Piutang</p>
                                <h3 class="mb-0 fw-bold">Rp 0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-wallet2 me-1"></i> Perlu collection
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-currency-dollar style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Pembayaran Masuk</p>
                                <h3 class="mb-0 fw-bold">Rp 0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +15% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-check-circle-fill style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Arus Kas</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="cashFlowChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Status Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    
    @role('customer')
        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Order</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-arrow-up-circle-fill me-1"></i> +10% dari bulan lalu
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-cart style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Order Aktif</p>
                                <h3 class="mb-0 fw-bold">0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-truck me-1"></i> Sedang diproses
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-box-seam style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 bg-gradient-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white-50 mb-1 small text-uppercase fw-semibold tracking-wider">Total Tagihan</p>
                                <h3 class="mb-0 fw-bold">Rp 0</h3>
                                <p class="text-white small mb-0 mt-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Semua lunas
                                </p>
                            </div>
                            <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                                <i class="bi bi-currency-dollar style="font-size: 1.5rem; line-height: 1;""></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Riwayat Order</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="orderHistoryChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0 fw-semibold">Status Order</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="customerOrderStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endrole
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
        color: white;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
        color: white;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);
        color: white;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        color: white;
    }
    
    .bg-gradient-danger {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        color: white;
    }
    
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-shape i {
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -20px;
        top: 20px;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item:last-child::before {
        display: none;
    }
    
    .timeline-marker {
        position: absolute;
        left: -29px;
        top: 0;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #e9ecef;
    }
    
    .timeline-marker.bg-primary {
        background: #2563EB;
    }
    
    .timeline-marker.bg-success {
        background: #16A34A;
    }
    
    .timeline-marker.bg-info {
        background: #0EA5E9;
    }
    
    .tracking-wider {
        letter-spacing: 0.05em;
    }
    
    /* Global Icon Consistency */
    h1 i, h2 i, h3 i, h4 i, h5 i, h6 i {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .card-header i {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn i {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .badge i {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .table i {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-group i {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-shape i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .text-uppercase {
        text-transform: uppercase;
    }
    
    .fw-semibold {
        font-weight: 600;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    .bg-success-subtle {
        background-color: rgba(22, 163, 74, 0.1);
    }
    
    .text-success {
        color: #16A34A;
    }
    
    .bg-secondary-subtle {
        background-color: rgba(107, 114, 128, 0.1);
    }
    
    .text-secondary {
        color: #6B7280;
    }
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Global chart instances for realtime updates
    let salesChart, categoryChart, salesPerformanceChart, orderStatusChart, warehouseStatusChart, cashFlowChart, paymentStatusChart, orderHistoryChart, customerOrderStatusChart;
    
    // Auto-refresh interval (30 seconds)
    const REFRESH_INTERVAL = 30000;
    
    @role('admin')
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Penjualan (Juta)',
                    data: [12, 19, 15, 25, 22, 30, 28, 35, 20, 25, 30, 40],
                    borderColor: '#16A34A',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Skin Care', 'Makeup', 'Hair Care', 'Body Care', 'Fragrance'],
                datasets: [{
                    data: [30, 25, 20, 15, 10],
                    backgroundColor: ['#16A34A', '#2563EB', '#F59E0B', '#DC2626', '#0EA5E9']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    @endrole
    
    @role('sales')
        // Sales Performance Chart
        const salesPerformanceCtx = document.getElementById('salesPerformanceChart');
        if (salesPerformanceCtx) {
            salesPerformanceChart = new Chart(salesPerformanceCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Penjualan (Juta)',
                        data: [15, 20, 18, 25, 22, 30],
                        backgroundColor: '#16A34A'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
        
        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart');
        if (orderStatusCtx) {
            orderStatusChart = new Chart(orderStatusCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Pending', 'Confirmed', 'Shipped', 'Delivered'],
                    datasets: [{
                        data: [20, 30, 25, 25],
                        backgroundColor: ['#F59E0B', '#0EA5E9', '#16A34A', '#DC2626']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    @endrole
    
    @role('admin_gudang')
        // Warehouse Status Chart
        const warehouseStatusCtx = document.getElementById('warehouseStatusChart');
        if (warehouseStatusCtx) {
            warehouseStatusChart = new Chart(warehouseStatusCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Gudang Utama', 'Gudang Cabang 1', 'Gudang Cabang 2'],
                    datasets: [{
                        label: 'Kapasitas (%)',
                        data: [75, 60, 45],
                        backgroundColor: ['#16A34A', '#2563EB', '#F59E0B']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y'
                }
            });
        }
    @endrole
    
    @role('finance')
        // Cash Flow Chart
        const cashFlowCtx = document.getElementById('cashFlowChart');
        if (cashFlowCtx) {
            cashFlowChart = new Chart(cashFlowCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Pemasukan',
                        data: [50, 60, 55, 70, 65, 80],
                        borderColor: '#16A34A',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        fill: true
                    }, {
                        label: 'Pengeluaran',
                        data: [30, 35, 32, 40, 38, 45],
                        borderColor: '#DC2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.1)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
        
        // Payment Status Chart
        const paymentStatusCtx = document.getElementById('paymentStatusChart');
        if (paymentStatusCtx) {
            paymentStatusChart = new Chart(paymentStatusCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Lunas', 'Pending', 'Jatuh Tempo'],
                    datasets: [{
                        data: [60, 25, 15],
                        backgroundColor: ['#16A34A', '#F59E0B', '#DC2626']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    @endrole
    
    @role('customer')
        // Order History Chart
        const orderHistoryCtx = document.getElementById('orderHistoryChart');
        if (orderHistoryCtx) {
            orderHistoryChart = new Chart(orderHistoryCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Jumlah Order',
                        data: [5, 8, 6, 10, 7, 12],
                        borderColor: '#16A34A',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
        
        // Customer Order Status Chart
        const customerOrderStatusCtx = document.getElementById('customerOrderStatusChart');
        if (customerOrderStatusCtx) {
            customerOrderStatusChart = new Chart(customerOrderStatusCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Sedang Diproses', 'Dikirim', 'Selesai'],
                    datasets: [{
                        data: [30, 40, 30],
                        backgroundColor: ['#0EA5E9', '#F59E0B', '#16A34A']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    @endrole

    // Realtime data fetching function
    function fetchRealtimeData() {
        fetch('/dashboard/realtime')
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    updateChartsWithRealtimeData(result.data);
                    updateLastUpdateTime();
                }
            })
            .catch(error => {
                console.error('Error fetching realtime data:', error);
            });
    }

    // Update charts with realtime data
    function updateChartsWithRealtimeData(data) {
        // Admin charts
        if (typeof salesChart !== 'undefined' && data.sales_data) {
            salesChart.data.labels = data.sales_data.labels;
            salesChart.data.datasets[0].data = data.sales_data.data;
            salesChart.update('none'); // Update without animation for smooth realtime updates
        }
        
        if (typeof categoryChart !== 'undefined' && data.category_data) {
            categoryChart.data.labels = data.category_data.labels;
            categoryChart.data.datasets[0].data = data.category_data.data;
            categoryChart.update('none');
        }

        // Sales charts
        if (typeof salesPerformanceChart !== 'undefined' && data.sales_performance) {
            salesPerformanceChart.data.labels = data.sales_performance.labels;
            salesPerformanceChart.data.datasets[0].data = data.sales_performance.data;
            salesPerformanceChart.update('none');
        }
        
        if (typeof orderStatusChart !== 'undefined' && data.order_status) {
            orderStatusChart.data.labels = data.order_status.labels;
            orderStatusChart.data.datasets[0].data = data.order_status.data;
            orderStatusChart.update('none');
        }

        // Admin Gudang charts
        if (typeof warehouseStatusChart !== 'undefined' && data.warehouse_status) {
            warehouseStatusChart.data.labels = data.warehouse_status.labels;
            warehouseStatusChart.data.datasets[0].data = data.warehouse_status.data;
            warehouseStatusChart.update('none');
        }

        // Finance charts
        if (typeof cashFlowChart !== 'undefined' && data.cash_flow) {
            cashFlowChart.data.labels = data.cash_flow.labels;
            cashFlowChart.data.datasets[0].data = data.cash_flow.income;
            cashFlowChart.data.datasets[1].data = data.cash_flow.expense;
            cashFlowChart.update('none');
        }
        
        if (typeof paymentStatusChart !== 'undefined' && data.payment_status) {
            paymentStatusChart.data.labels = data.payment_status.labels;
            paymentStatusChart.data.datasets[0].data = data.payment_status.data;
            paymentStatusChart.update('none');
        }

        // Customer charts
        if (typeof orderHistoryChart !== 'undefined' && data.order_history) {
            orderHistoryChart.data.labels = data.order_history.labels;
            orderHistoryChart.data.datasets[0].data = data.order_history.data;
            orderHistoryChart.update('none');
        }
        
        if (typeof customerOrderStatusChart !== 'undefined' && data.order_status) {
            customerOrderStatusChart.data.labels = data.order_status.labels;
            customerOrderStatusChart.data.datasets[0].data = data.order_status.data;
            customerOrderStatusChart.update('none');
        }
    }

    // Start auto-refresh on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initial data fetch
        fetchRealtimeData();
        
        // Set up auto-refresh interval
        setInterval(fetchRealtimeData, REFRESH_INTERVAL);
        
        // Show last update time indicator
        const updateIndicator = document.createElement('div');
        updateIndicator.className = 'position-fixed bottom-0 end-0 p-3';
        updateIndicator.style.zIndex = '1000';
        updateIndicator.innerHTML = `
            <div class="bg-white border rounded shadow-sm p-2 d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                <div class="spinner-border spinner-border-sm text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="text-muted">Auto-refresh: ${REFRESH_INTERVAL/1000}s</span>
                <span class="text-muted" id="lastUpdateTime">-</span>
            </div>
        `;
        document.body.appendChild(updateIndicator);
        
        // Update last update time
        function updateLastUpdateTime() {
            const now = new Date();
            document.getElementById('lastUpdateTime').textContent = 'Updated: ' + now.toLocaleTimeString();
        }
        
        updateLastUpdateTime();
        setInterval(updateLastUpdateTime, REFRESH_INTERVAL);
    });
</script>
@endpush
@endsection