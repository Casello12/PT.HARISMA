@extends('layouts.app')

@section('title', 'Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-truck me-2 text-success"></i>
                        Pengiriman
                    </h1>
                    <p class="text-muted mb-0">Kelola pengiriman produk ke customer</p>
                </div>
                <a href="{{ route('shipments.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Buat Pengiriman
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
                            <h5 class="mb-0 fw-semibold">Daftar Pengiriman</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_transit">In Transit</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari pengiriman..." id="search">
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
                                    <th>No. Pengiriman</th>
                                    <th>Tanggal</th>
                                    <th>Sales Order</th>
                                    <th>Customer</th>
                                    <th>Gudang</th>
                                    <th>Kurir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shipments as $index => $shipment)
                                    <tr>
                                        <td>{{ ($shipments->currentPage() - 1) * $shipments->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $shipment->shipment_number }}</code></td>
                                        <td>{{ $shipment->shipping_date->format('d-m-Y') }}</td>
                                        <td><code>{{ $shipment->salesOrder->order_number }}</code></td>
                                        <td class="fw-medium">{{ $shipment->salesOrder->customer->name }}</td>
                                        <td>{{ $shipment->warehouse->name }}</td>
                                        <td>{{ $shipment->carrier }}</td>
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
                                            <div class="btn-group">
                                                <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i>
                                                </a>
                                                @if($shipment->status === 'pending')
                                                    <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil" style="font-size: 1rem; line-height: 1;"></i>
                                                    </a>
                                                    <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengiriman ini?')">
                                                            <i class="bi bi-trash" style="font-size: 1rem; line-height: 1;"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($shipment->status === 'in_transit')
                                                    <button class="btn btn-sm btn-success update-tracking-btn" data-shipment-id="{{ $shipment->id }}">
                                                        <i class="bi bi-geo-alt" style="font-size: 1rem; line-height: 1;"></i> Update Tracking
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data pengiriman</p>
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

<!-- Update Tracking Modal -->
<div class="modal fade" id="updateTrackingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Tracking Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateTrackingForm">
                    @csrf
                    <input type="hidden" id="trackingShipmentId" name="shipment_id">
                    <div class="mb-3">
                        <label for="trackingStatus" class="form-label">Status</label>
                        <select class="form-select" id="trackingStatus" name="status" required>
                            <option value="in_transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="trackingLocation" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="trackingLocation" name="location" required placeholder="Contoh: Jakarta, Gudang Hub">
                    </div>
                    <div class="mb-3">
                        <label for="trackingNotes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="trackingNotes" name="notes" rows="3" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveTrackingBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateTrackingModal = new bootstrap.Modal(document.getElementById('updateTrackingModal'));
    
    // Handle update tracking button clicks
    document.querySelectorAll('.update-tracking-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const shipmentId = this.getAttribute('data-shipment-id');
            document.getElementById('trackingShipmentId').value = shipmentId;
            updateTrackingModal.show();
        });
    });
    
    // Handle save tracking
    document.getElementById('saveTrackingBtn').addEventListener('click', function() {
        const form = document.getElementById('updateTrackingForm');
        const formData = new FormData(form);
        const shipmentId = document.getElementById('trackingShipmentId').value;
        
        fetch(`/shipments/${shipmentId}/tracking`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTrackingModal.hide();
                location.reload();
            } else {
                alert('Gagal mengupdate tracking: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengupdate tracking');
        });
    });
});
</script>
@endsection