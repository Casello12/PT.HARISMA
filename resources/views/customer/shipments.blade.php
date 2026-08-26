@extends('layouts.app')

@section('title', 'Tracking Pengiriman')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-truck me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Tracking Pengiriman
                    </h1>
                    <p class="text-muted mb-0">Lacak status pengiriman pesanan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Daftar Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pengiriman</th>
                                    <th>No. Order</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Kurir</th>
                                    <th>Tracking</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shipments as $shipment)
                                    <tr>
                                        <td>
                                            <code>{{ $shipment->shipment_number }}</code>
                                        </td>
                                        <td>
                                            <a href="#" class="text-decoration-none fw-medium">
                                                <code>{{ $shipment->salesOrder->order_number }}</code>
                                            </a>
                                        </td>
                                        <td>{{ $shipment->shipping_date->format('d-m-Y') }}</td>
                                        <td>{{ $shipment->carrier }}</td>
                                        <td>
                                            @if($shipment->tracking_number)
                                                <code>{{ $shipment->tracking_number }}</code>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($shipment->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                                            @elseif($shipment->status === 'in_transit')
                                                <span class="badge bg-info-subtle text-info">In Transit</span>
                                            @elseif($shipment->status === 'delivered')
                                                <span class="badge bg-success-subtle text-success">Delivered</span>
                                            @elseif($shipment->status === 'cancelled')
                                                <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $shipment->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-geo-alt" style="font-size: 1rem; line-height: 1;"></i> Track
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada pengiriman</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $shipments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
