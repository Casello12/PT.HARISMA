@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-file-earmark-text me-2 text-success"></i>
                        Invoice
                    </h1>
                    <p class="text-muted mb-0">Kelola invoice penjualan</p>
                </div>
                @hasanyrole(['admin', 'finance'])
                    <a href="{{ route('invoices.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg me-1"></i> Buat Invoice
                    </a>
                @endhasanyrole
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h5 class="mb-0 fw-semibold">Daftar Invoice</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="unpaid">Unpaid</option>
                                <option value="partial">Partial</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari invoice..." id="search">
                                <button class="btn btn-outline-success" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $index => $invoice)
                                    <tr>
                                        <td>{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $invoice->invoice_number }}</code></td>
                                        <td>{{ $invoice->invoice_date->format('d-m-Y') }}</td>
                                        <td class="fw-medium">{{ $invoice->customer->name }}</td>
                                        <td class="fw-semibold text-success">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($invoice->payment_status === 'unpaid')
                                                <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                            @elseif($invoice->payment_status === 'partial')
                                                <span class="badge bg-warning-subtle text-warning">Partial</span>
                                            @elseif($invoice->payment_status === 'paid')
                                                <span class="badge bg-success-subtle text-success">Paid</span>
                                            @elseif($invoice->payment_status === 'overdue')
                                                <span class="badge bg-danger-subtle text-danger">Overdue</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $invoice->payment_status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i>
                                                </a>
                                                @hasanyrole(['admin', 'finance'])
                                                    @if($invoice->payment_status === 'unpaid' || $invoice->payment_status === 'partial')
                                                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil" style="font-size: 1rem; line-height: 1;"></i>
                                                        </a>
                                                    @endif
                                                    @if($invoice->payments()->count() === 0)
                                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus invoice ini?')">
                                                                <i class="bi bi-trash" style="font-size: 1rem; line-height: 1;"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endhasanyrole
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data invoice</p>
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
@endsection