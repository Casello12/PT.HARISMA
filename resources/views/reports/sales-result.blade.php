@extends('layouts.app')

@section('title', 'Hasil Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Hasil Laporan Penjualan</h5>
                    <form action="{{ route('reports.sales.pdf') }}" method="GET" class="d-inline">
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
                                    <h6 class="card-title">Total Order</h6>
                                    <h3 class="card-text">{{ $totalOrders }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Pendapatan</h6>
                                    <h3 class="card-text">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Dibayar</h6>
                                    <h3 class="card-text">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h3>
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
                                    <th>No. Order</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Dibayar</th>
                                    <th>Pending</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salesOrders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                        <td>{{ $order->customer->name ?? '-' }}</td>
                                        <td>{{ $order->sales->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'primary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('reports.sales.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
