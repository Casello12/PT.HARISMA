@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Laporan Penjualan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.sales.generate') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', now()->startOfMonth()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', now()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option value="">Semua Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sales_id" class="form-label">Sales</label>
                            <select class="form-select" id="sales_id" name="sales_id">
                                <option value="">Semua Sales</option>
                                @foreach($sales as $sale)
                                    <option value="{{ $sale->id }}" {{ old('sales_id') == $sale->id ? 'selected' : '' }}>{{ $sale->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending_confirmation" {{ old('status') == 'pending_confirmation' ? 'selected' : '' }}>Pending Confirmation</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="awaiting_payment" {{ old('status') == 'awaiting_payment' ? 'selected' : '' }}>Awaiting Payment</option>
                                <option value="payment_verified" {{ old('status') == 'payment_verified' ? 'selected' : '' }}>Payment Verified</option>
                                <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="packing" {{ old('status') == 'packing' ? 'selected' : '' }}>Packing</option>
                                <option value="ready_to_ship" {{ old('status') == 'ready_to_ship' ? 'selected' : '' }}>Ready to Ship</option>
                                <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="in_transit" {{ old('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Generate Laporan
                            </button>
                            <a href="{{ route('reports.sales.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
