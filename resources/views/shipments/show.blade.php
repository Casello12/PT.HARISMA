@extends('layouts.app')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-eye me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Detail Pengiriman
                    </h1>
                    <p class="text-muted mb-0">Informasi lengkap pengiriman <code>{{ $shipment->shipment_number }}</code></p>
                </div>
                <a href="{{ route('shipments.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1" style="font-size: 1rem; line-height: 1;"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">No. Pengiriman</th>
                                    <td><code>{{ $shipment->shipment_number }}</code></td>
                                </tr>
                                <tr>
                                    <th>Sales Order</th>
                                    <td><a href="{{ route('sales-orders.show', $shipment->salesOrder) }}" class="text-decoration-none"><code>{{ $shipment->salesOrder->order_number }}</code></a></td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td class="fw-medium">{{ $shipment->salesOrder->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Gudang</th>
                                    <td>{{ $shipment->warehouse->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kurir</th>
                                    <td>{{ $shipment->carrier }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Tracking</th>
                                    <td><code>{{ $shipment->tracking_number ?? '-' }}</code></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Tanggal Pengiriman</th>
                                    <td>{{ $shipment->shipping_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Estimasi Sampai</th>
                                    <td>{{ $shipment->estimated_delivery_date ? $shipment->estimated_delivery_date->format('d-m-Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Biaya Pengiriman</th>
                                    <td class="fw-semibold text-success">Rp {{ number_format($shipment->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $shipment->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($shipment->notes)
                        <div class="mt-3 p-3 bg-light rounded">
                            <strong class="fw-semibold">Catatan:</strong>
                            <p class="text-muted mb-0">{{ $shipment->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Item Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shipment->items as $item)
                                    <tr>
                                        <td class="fw-medium">{{ $item->product->name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">Riwayat Tracking</h5>
                        @if($shipment->status !== 'delivered')
                            <span class="badge bg-success-subtle text-success">
                                <span class="realtime-indicator"></span> Realtime
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($shipment->tracking as $index => $track)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker bg-{{ $track->status === 'delivered' ? 'success' : ($track->status === 'cancelled' ? 'danger' : 'primary') }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <strong class="fw-semibold">{{ ucfirst($track->status) }}</strong>
                                        <small class="text-muted">{{ $track->tracking_date->format('d-m-Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted">{{ $track->location }}</p>
                                    @if($track->notes)
                                        <small class="text-muted">{{ $track->notes }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                @if($shipment->status === 'pending')
                    <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1" style="font-size: 1rem; line-height: 1;"></i> Edit
                    </a>
                    <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengiriman ini?')">
                            <i class="bi bi-trash me-1" style="font-size: 1rem; line-height: 1;"></i> Hapus
                        </button>
                    </form>
                @endif
                @if($shipment->status === 'in_transit')
                    <button class="btn btn-success update-tracking-btn" data-shipment-id="{{ $shipment->id }}">
                        <i class="bi bi-geo-alt me-1" style="font-size: 1rem; line-height: 1;"></i> Update Tracking
                    </button>
                @endif
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
                        <label for="trackingStatus" class="form-label fw-medium">Status</label>
                        <select class="form-select" id="trackingStatus" name="status" required>
                            <option value="in_transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="trackingLocation" class="form-label fw-medium">Lokasi</label>
                        <input type="text" class="form-control" id="trackingLocation" name="location" required placeholder="Contoh: Jakarta, Gudang Hub">
                    </div>
                    <div class="mb-3">
                        <label for="trackingNotes" class="form-label fw-medium">Catatan</label>
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

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
.timeline-item {
    position: relative;
}
.timeline-marker {
    position: absolute;
    left: -26px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}
.realtime-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: #16A34A;
    border-radius: 50%;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

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
    
    // Realtime tracking update
    function updateTracking() {
        fetch(`/shipments/{{ $shipment->id }}/tracking`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const trackingContainer = document.querySelector('.timeline');
                    if (trackingContainer) {
                        let html = '';
                        data.shipment.tracking.forEach((track, index) => {
                            const statusClass = track.status === 'delivered' ? 'success' : (track.status === 'cancelled' ? 'danger' : 'primary');
                            html += `
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker bg-${statusClass}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <strong class="fw-semibold">${track.status.charAt(0).toUpperCase() + track.status.slice(1)}</strong>
                                            <small class="text-muted">${new Date(track.tracking_date).toLocaleString('id-ID')}</small>
                                        </div>
                                        <p class="mb-0 text-muted">${track.location}</p>
                                        ${track.notes ? `<small class="text-muted">${track.notes}</small>` : ''}
                                    </div>
                                </div>
                            `;
                        });
                        trackingContainer.innerHTML = html;
                    }
                }
            })
            .catch(error => console.error('Error updating tracking:', error));
    }

    // Update tracking every 30 seconds if shipment is not delivered
    {{ $shipment->status !== 'delivered' ? 'setInterval(updateTracking, 30000);' : '' }}
    // Initial load
    updateTracking();
});
</script>
@endsection