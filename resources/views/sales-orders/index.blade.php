@extends('layouts.app')

@section('title', 'Sales Order')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-cart me-2 text-success"></i>
                        Sales Order
                    </h1>
                    <p class="text-muted mb-0">Kelola pesanan penjualan</p>
                </div>
                <a href="{{ route('sales-orders.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Buat Sales Order
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h5 class="mb-0 fw-semibold">Daftar Sales Order</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="draft">Draft</option>
                                <option value="pending_confirmation">Pending Confirmation</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="awaiting_payment">Awaiting Payment</option>
                                <option value="payment_verified">Payment Verified</option>
                                <option value="processing">Processing</option>
                                <option value="packing">Packing</option>
                                <option value="ready_to_ship">Ready to Ship</option>
                                <option value="shipped">Shipped</option>
                                <option value="in_transit">In Transit</option>
                                <option value="delivered">Delivered</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari order..." id="search">
                                <button class="btn btn-outline-success" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>No. Order</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Sales</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salesOrders as $index => $order)
                                    <tr>
                                        <td>{{ ($salesOrders->currentPage() - 1) * $salesOrders->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $order->order_number }}</code></td>
                                        <td>{{ $order->order_date->format('d-m-Y') }}</td>
                                        <td class="fw-medium">{{ $order->customer->name }}</td>
                                        <td>{{ $order->sales->name ?? '-' }}</td>
                                        <td class="fw-semibold text-success">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status === 'draft')
                                                <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                                            @elseif($order->status === 'pending_confirmation')
                                                <span class="badge bg-warning-subtle text-warning">Pending Confirmation</span>
                                            @elseif($order->status === 'confirmed')
                                                <span class="badge bg-info-subtle text-info">Confirmed</span>
                                            @elseif($order->status === 'awaiting_payment')
                                                <span class="badge bg-warning-subtle text-warning">Awaiting Payment</span>
                                            @elseif($order->status === 'payment_verified')
                                                <span class="badge bg-success-subtle text-success">Payment Verified</span>
                                            @elseif($order->status === 'processing')
                                                <span class="badge bg-primary-subtle text-primary">Processing</span>
                                            @elseif($order->status === 'packing')
                                                <span class="badge bg-primary-subtle text-primary">Packing</span>
                                            @elseif($order->status === 'ready_to_ship')
                                                <span class="badge bg-info-subtle text-info">Ready to Ship</span>
                                            @elseif($order->status === 'shipped')
                                                <span class="badge bg-info-subtle text-info">Shipped</span>
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
                                            <div class="btn-group">
                                                <a href="{{ route('sales-orders.show', $order) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i>
                                                </a>
                                                @if($order->status === 'draft' || $order->status === 'cancelled')
                                                    <a href="{{ route('sales-orders.edit', $order) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil" style="font-size: 1rem; line-height: 1;"></i>
                                                    </a>
                                                    <form action="{{ route('sales-orders.destroy', $order) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
                                                            <i class="bi bi-trash" style="font-size: 1rem; line-height: 1;"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data sales order</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $salesOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection