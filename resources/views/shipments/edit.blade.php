@extends('layouts.app')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Pengiriman
                </h1>
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('shipments.update', $shipment) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="warehouse_id" class="form-label">Gudang <span class="text-danger">*</span></label>
                                    <select class="form-select @error('warehouse_id') is-invalid @enderror" 
                                            id="warehouse_id" name="warehouse_id" required>
                                        <option value="">Pilih Gudang</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $shipment->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="shipping_date" class="form-label">Tanggal Pengiriman <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('shipping_date') is-invalid @enderror" 
                                           id="shipping_date" name="shipping_date" value="{{ old('shipping_date', $shipment->shipping_date->format('Y-m-d')) }}" required>
                                    @error('shipping_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="estimated_delivery_date" class="form-label">Estimasi Tanggal Sampai</label>
                                    <input type="date" class="form-control @error('estimated_delivery_date') is-invalid @enderror" 
                                           id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $shipment->estimated_delivery_date ? $shipment->estimated_delivery_date->format('Y-m-d') : '') }}">
                                    @error('estimated_delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="carrier" class="form-label">Kurir <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('carrier') is-invalid @enderror" 
                                           id="carrier" name="carrier" value="{{ old('carrier', $shipment->carrier) }}" required>
                                    @error('carrier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tracking_number" class="form-label">Nomor Tracking</label>
                                    <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                           id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $shipment->tracking_number) }}">
                                    @error('tracking_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="shipping_cost" class="form-label">Biaya Pengiriman</label>
                                    <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" 
                                           id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost', $shipment->shipping_cost) }}" min="0" step="0.01">
                                    @error('shipping_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pending" {{ old('status', $shipment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_transit" {{ old('status', $shipment->status) == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ old('status', $shipment->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ old('status', $shipment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="2">{{ old('notes', $shipment->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection