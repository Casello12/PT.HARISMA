@extends('layouts.app')

@section('title', 'Edit Piutang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Piutang
                </h1>
                <a href="{{ route('accounts-receivable.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Piutang dikelola melalui invoice dan pembayaran. Silakan kelola melalui menu Invoice dan Pembayaran.
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <a href="{{ route('invoices.create') }}?customer_id={{ $customer->id }}" class="btn btn-primary btn-block">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Buat Invoice
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('payments.create') }}" class="btn btn-success btn-block">
                                <i class="bi bi-currency-dollar me-2"></i>
                                Terima Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection