@extends('layouts.app')

@section('title', 'Detail Piutang Customer')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-eye me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Detail Piutang Customer
                    </h1>
                    <p class="text-muted mb-0">Informasi piutang untuk <strong>{{ $customer->name }}</strong></p>
                </div>
                <a href="{{ route('accounts-receivable.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1" style="font-size: 1rem; line-height: 1;"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-gradient-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Total Piutang</h5>
                            <h3 class="card-text fw-bold mb-0">Rp {{ number_format($totalDue, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                            <i class="bi bi-wallet2" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-gradient-danger text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Jatuh Tempo</h5>
                            <h3 class="card-text fw-bold mb-0">Rp {{ number_format($overdueAmount, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                            <i class="bi bi-exclamation-triangle" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Invoice Belum Lunas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Jatuh Tempo</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Dibayar</th>
                                    <th class="text-end">Sisa</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->invoices as $invoice)
                                    <tr>
                                        <td><a href="{{ route('invoices.show', $invoice) }}" class="text-decoration-none fw-medium"><code>{{ $invoice->invoice_number }}</code></a></td>
                                        <td>{{ $invoice->invoice_date->format('d-m-Y') }}</td>
                                        <td>
                                            {{ $invoice->due_date->format('d-m-Y') }}
                                            @if($invoice->due_date < now())
                                                <span class="badge bg-danger-subtle text-danger ms-1">Overdue</span>
                                            @endif
                                        </td>
                                        <td class="text-end">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold text-danger">Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if($invoice->payment_status === 'unpaid')
                                                <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                            @elseif($invoice->payment_status === 'partial')
                                                <span class="badge bg-warning-subtle text-warning">Partial</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $invoice->payment_status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-currency-dollar" style="font-size: 1rem; line-height: 1;"></i> Bayar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada invoice yang belum lunas</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-shape i {
    font-size: 1.5rem;
    line-height: 1;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #16A34A 0%, #15803D 50%, #166534 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 50%, #991B1B 100%);
}
</style>
@endsection