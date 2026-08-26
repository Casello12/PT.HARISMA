@extends('layouts.app')

@section('title', 'Edit Pengingat Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Pengingat Pembayaran
                </h1>
                <a href="{{ route('payment-reminders.index') }}" class="btn btn-secondary">
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
                        Pengingat pembayaran dikelola melalui pengiriman pesan. Silakan kirim pengingat baru melalui menu Kirim Pengingat.
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('payment-reminders.create') }}?invoice_id={{ $invoice->id }}" class="btn btn-success btn-lg">
                            <i class="bi bi-send me-2"></i>
                            Kirim Pengingat Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection