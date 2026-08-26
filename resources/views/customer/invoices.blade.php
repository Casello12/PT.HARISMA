@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-file-earmark-text me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Invoice
                    </h1>
                    <p class="text-muted mb-0">Kelola tagihan dan pembayaran Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-gradient-danger text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3 me-3">
                            <i class="bi bi-exclamation-circle" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 opacity-75">Total Tagihan</h6>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($invoices->where('payment_status', '!=', 'paid')->sum('remaining_amount'), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3 me-3">
                            <i class="bi bi-check-circle" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 opacity-75">Sudah Dibayar</h6>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($invoices->where('payment_status', 'paid')->sum('paid_amount'), 0, ',', '.') }}</h3>
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
                    <h5 class="mb-0 fw-semibold">Daftar Invoice</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Total</th>
                                    <th>Dibayar</th>
                                    <th>Sisa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <a href="#" class="text-decoration-none fw-medium">
                                                <code>{{ $invoice->invoice_number }}</code>
                                            </a>
                                        </td>
                                        <td>{{ $invoice->invoice_date->format('d-m-Y') }}</td>
                                        <td>
                                            {{ $invoice->due_date->format('d-m-Y') }}
                                            @if($invoice->due_date < now() && $invoice->payment_status !== 'paid')
                                                <span class="badge bg-danger-subtle text-danger ms-1">Overdue</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                                        <td class="text-success">Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                                        <td class="fw-semibold text-danger">Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($invoice->payment_status === 'unpaid')
                                                <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                            @elseif($invoice->payment_status === 'partial')
                                                <span class="badge bg-warning-subtle text-warning">Partial</span>
                                            @elseif($invoice->payment_status === 'paid')
                                                <span class="badge bg-success-subtle text-success">Paid</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $invoice->payment_status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i>
                                                </a>
                                                @if($invoice->payment_status !== 'paid')
                                                    <a href="#" class="btn btn-sm btn-success">
                                                        <i class="bi bi-currency-dollar" style="font-size: 1rem; line-height: 1;"></i> Bayar
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada invoice</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $invoices->links() }}
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

.bg-gradient-danger {
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 50%, #991B1B 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #16A34A 0%, #15803D 50%, #166534 100%);
}
</style>
@endsection
