@extends('layouts.app')

@section('title', 'Tracking Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-geo-alt me-2"></i>
                    Tracking Pengiriman
                </h1>
                <a href="{{ route('shipment-tracking.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Tracking
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Riwayat Tracking</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari tracking..." id="search">
                                <button class="btn btn-outline-success" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengiriman</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tracking as $index => $track)
                                    <tr>
                                        <td>{{ ($tracking->currentPage() - 1) * $tracking->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $track->shipment->shipment_number }}</code></td>
                                        <td>
                                            @if($track->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($track->status === 'in_transit')
                                                <span class="badge bg-info">In Transit</span>
                                            @elseif($track->status === 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($track->status === 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $track->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $track->location }}</td>
                                        <td>{{ $track->tracking_date->format('d-m-Y H:i') }}</td>
                                        <td>{{ $track->notes ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('shipment-tracking.show', $track) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('shipment-tracking.edit', $track) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('shipment-tracking.destroy', $track) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tracking ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data tracking</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $tracking->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection