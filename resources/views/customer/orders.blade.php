@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-cart me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Pesanan Saya
                    </h1>
                    <p class="text-muted mb-0">Kelola dan lacak pesanan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3 me-3">
                            <i class="bi bi-hourglass" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 opacity-75">Pending</h6>
                            <h3 class="mb-0 fw-bold">{{ $orders->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3 me-3">
                            <i class="bi bi-arrow-repeat" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 opacity-75">Diproses</h6>
                            <h3 class="mb-0 fw-bold">{{ $orders->whereIn('status', ['approved', 'processing', 'packing'])->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3 me-3">
                            <i class="bi bi-truck" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 opacity-75">Dikirim</h6>
                            <h3 class="mb-0 fw-bold">{{ $orders->whereIn('status', ['shipped', 'in_transit'])->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3 me-3">
                            <i class="bi bi-check-circle" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 opacity-75">Selesai</h6>
                            <h3 class="mb-0 fw-bold">{{ $orders->whereIn('status', ['delivered', 'completed'])->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Daftar Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Order</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="#" class="text-decoration-none fw-medium">
                                                <code>{{ $order->order_number }}</code>
                                            </a>
                                        </td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td class="fw-semibold text-success">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                                            @elseif($order->status === 'approved')
                                                <span class="badge bg-info-subtle text-info">Approved</span>
                                            @elseif($order->status === 'processing')
                                                <span class="badge bg-info-subtle text-info">Processing</span>
                                            @elseif($order->status === 'packing')
                                                <span class="badge bg-info-subtle text-info">Packing</span>
                                            @elseif($order->status === 'shipped')
                                                <span class="badge bg-primary-subtle text-primary">Shipped</span>
                                            @elseif($order->status === 'in_transit')
                                                <span class="badge bg-primary-subtle text-primary">In Transit</span>
                                            @elseif($order->status === 'delivered')
                                                <span class="badge bg-success-subtle text-success">Delivered</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge bg-success-subtle text-success">Completed</span>
                                            @elseif($order->status === 'cancelled')
                                                <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                @php
                                                    $progress = 0;
                                                    if (in_array($order->status, ['pending'])) $progress = 10;
                                                    elseif (in_array($order->status, ['approved'])) $progress = 25;
                                                    elseif (in_array($order->status, ['processing', 'packing'])) $progress = 50;
                                                    elseif (in_array($order->status, ['shipped', 'in_transit'])) $progress = 75;
                                                    elseif (in_array($order->status, ['delivered', 'completed'])) $progress = 100;
                                                @endphp
                                                <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $progress }}%</small>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada pesanan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

.bg-gradient-success {
    background: linear-gradient(135deg, #16A34A 0%, #15803D 50%, #166534 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 50%, #0369A1 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #B45309 100%);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 50%, #1E40AF 100%);
}
</style>
@endsection
