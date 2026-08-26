@extends('layouts.app')

@section('title', 'Hasil Laporan Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-currency-dollar"></i> Hasil Laporan Pembayaran</h5>
                    <form action="{{ route('reports.payment.pdf') }}" method="GET" class="d-inline">
                        @foreach($validated as $key => $value)
                            @if($value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($validated['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($validated['end_date'])->format('d/m/Y') }}
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Pembayaran</h6>
                                    <h3 class="card-text">{{ $totalPayments }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Amount</h6>
                                    <h3 class="card-text">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Verified</h6>
                                    <h3 class="card-text">Rp {{ number_format($totalVerified, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Pending</h6>
                                    <h3 class="card-text">Rp {{ number_format($totalPending, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No. Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>No. Invoice</th>
                                    <th>Customer</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                        <td>{{ $payment->invoice->invoice_number ?? '-' }}</td>
                                        <td>{{ $payment->invoice->customer->name ?? '-' }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('reports.payment.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
