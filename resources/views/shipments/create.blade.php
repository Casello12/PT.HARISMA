@extends('layouts.app')

@section('title', 'Buat Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-plus-circle me-2 text-success"></i>
                        Buat Pengiriman
                    </h1>
                    <p class="text-muted mb-0">Buat pengiriman baru untuk sales order</p>
                </div>
                <a href="{{ route('shipments.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Form Pengiriman</h5>
                </div>
                <div class="card-body">
                    @if($salesOrders->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Tidak ada sales order yang tersedia untuk pengiriman. Sales order harus dalam status pembayaran terverifikasi atau siap dikirim.
                        </div>
                        <a href="{{ route('sales-orders.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i> Ke Daftar Sales Order
                        </a>
                    @else
                        <form method="POST" action="{{ route('shipments.store') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sales_order_id" class="form-label fw-medium">Sales Order <span class="text-danger">*</span></label>
                                        <select class="form-select @error('sales_order_id') is-invalid @enderror" 
                                                id="sales_order_id" name="sales_order_id" required onchange="loadOrderDetails()">
                                            <option value="">Pilih Sales Order</option>
                                            @foreach($salesOrders as $order)
                                                <option value="{{ $order->id }}" 
                                                        data-customer="{{ $order->customer->name }}"
                                                        data-total="{{ $order->grand_total }}"
                                                        {{ old('sales_order_id') == $order->id ? 'selected' : '' }}>
                                                    {{ $order->order_number }} - {{ $order->customer->name }} (Rp {{ number_format($order->grand_total, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sales_order_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="warehouse_id" class="form-label fw-medium">Gudang <span class="text-danger">*</span></label>
                                        <select class="form-select @error('warehouse_id') is-invalid @enderror" 
                                                id="warehouse_id" name="warehouse_id" required>
                                            <option value="">Pilih Gudang</option>
                                            @foreach($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="shipping_date" class="form-label fw-medium">Tanggal Pengiriman <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('shipping_date') is-invalid @enderror" 
                                               id="shipping_date" name="shipping_date" value="{{ old('shipping_date', now()->format('Y-m-d')) }}" required>
                                        @error('shipping_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="estimated_delivery_date" class="form-label fw-medium">Estimasi Tanggal Sampai</label>
                                        <input type="date" class="form-control @error('estimated_delivery_date') is-invalid @enderror" 
                                               id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date') }}">
                                        @error('estimated_delivery_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="carrier" class="form-label fw-medium">Kurir <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('carrier') is-invalid @enderror" 
                                               id="carrier" name="carrier" value="{{ old('carrier') }}" required placeholder="Contoh: JNE, J&T, Gojek">
                                        @error('carrier')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tracking_number" class="form-label fw-medium">Nomor Tracking</label>
                                        <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                               id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}" placeholder="Nomor resi kurir">
                                        @error('tracking_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="shipping_cost" class="form-label fw-medium">Biaya Pengiriman</label>
                                        <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" 
                                               id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost') }}" min="0" step="0.01" placeholder="0">
                                        @error('shipping_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="notes" class="form-label fw-medium">Catatan</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="2" placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('shipments.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection