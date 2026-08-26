@extends('layouts.app')

@section('title', 'Tambah Piutang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Piutang
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
                        Piutang dihitung otomatis dari invoice yang belum lunas. Silakan buat invoice baru untuk menambah piutang.
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Buat Invoice Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection