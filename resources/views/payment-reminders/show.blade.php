@extends('layouts.app')

@section('title', 'Detail Pengingat Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Pengingat Pembayaran
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
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">No. Invoice</th>
                                    <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>{{ $invoice->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Jatuh Tempo</th>
                                    <td>{{ $invoice->due_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        @if($invoice->payment_status === 'unpaid')
                                            <span class="badge bg-danger">Unpaid</span>
                                        @elseif($invoice->payment_status === 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $invoice->payment_status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Total</th>
                                    <td>Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Dibayar</th>
                                    <td>Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Sisa</th>
                                    <td><strong>Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($invoice->due_date < now())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-success">Belum Jatuh Tempo</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('payment-reminders.create') }}?invoice_id={{ $invoice->id }}" class="btn btn-success">
                            <i class="bi bi-send me-1"></i> Kirim Pengingat Baru
                        </a>
                        <a href="{{ route('payments.create') }}?invoice_id={{ $invoice->id }}" class="btn btn-primary">
                            <i class="bi bi-currency-dollar me-1"></i> Terima Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection