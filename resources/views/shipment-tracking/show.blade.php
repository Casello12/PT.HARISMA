@extends('layouts.app')

@section('title', 'Detail Tracking')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Tracking
                </h1>
                <a href="{{ route('shipment-tracking.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Pengiriman</th>
                                    <td><a href="{{ route('shipments.show', $tracking->shipment) }}">{{ $tracking->shipment->shipment_number }}</a></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($tracking->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($tracking->status === 'in_transit')
                                            <span class="badge bg-info">In Transit</span>
                                        @elseif($tracking->status === 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($tracking->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $tracking->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $tracking->location }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Tanggal Tracking</th>
                                    <td>{{ $tracking->tracking_date->format('d-m-Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $tracking->notes ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $tracking->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('shipment-tracking.edit', $tracking) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection