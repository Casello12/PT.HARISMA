@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Pembayaran
                </h1>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
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
                                    <th width="30%">Nomor Pembayaran</th>
                                    <td><code>{{ $payment->payment_number }}</code></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Invoice</th>
                                    <td><a href="{{ route('invoices.show', $payment->invoice) }}">{{ $payment->invoice->invoice_number }}</a></td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>{{ $payment->invoice->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($payment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($payment->status === 'verified')
                                            <span class="badge bg-success">Verified</span>
                                        @elseif($payment->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $payment->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Jumlah</th>
                                    <td><strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Nama Bank</th>
                                    <td>{{ $payment->bank_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Rekening</th>
                                    <td>{{ $payment->account_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pemilik</th>
                                    <td>{{ $payment->account_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Referensi</th>
                                    <td>{{ $payment->reference_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Diverifikasi Oleh</th>
                                    <td>{{ $payment->verifiedBy ? $payment->verifiedBy->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Verifikasi</th>
                                    <td>{{ $payment->verified_at ? $payment->verified_at->format('d-m-Y H:i') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($payment->notes)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="text-muted mb-0">{{ $payment->notes }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        @if($payment->status === 'pending')
                            <form action="{{ route('payments.verify', $payment) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin memverifikasi pembayaran ini?')">
                                    <i class="bi bi-check me-1"></i> Verifikasi
                                </button>
                            </form>
                            <form action="{{ route('payments.reject', $payment) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                    <i class="bi bi-x me-1"></i> Tolak
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection