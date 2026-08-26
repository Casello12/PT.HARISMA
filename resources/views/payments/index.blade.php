@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-currency-dollar me-2 text-success"></i>
                        Pembayaran
                    </h1>
                    <p class="text-muted mb-0">Kelola pembayaran invoice</p>
                </div>
                @hasanyrole(['admin', 'finance'])
                    <a href="{{ route('payments.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg me-1"></i> Buat Pembayaran
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
                            <h5 class="mb-0 fw-semibold">Daftar Pembayaran</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="verified">Verified</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari pembayaran..." id="search">
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
                                    <th>No. Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $index => $payment)
                                    <tr>
                                        <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $payment->payment_number }}</code></td>
                                        <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                        <td><code>{{ $payment->invoice->invoice_number }}</code></td>
                                        <td class="fw-medium">{{ $payment->invoice->customer->name }}</td>
                                        <td class="fw-semibold text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>
                                            @if($payment->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                                            @elseif($payment->status === 'verified')
                                                <span class="badge bg-success-subtle text-success">Verified</span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="badge bg-danger-subtle text-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $payment->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i>
                                                </a>
                                                @hasanyrole(['admin', 'finance'])
                                                    @if($payment->status === 'pending')
                                                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil" style="font-size: 1rem; line-height: 1;"></i>
                                                        </a>
                                                        <form action="{{ route('payments.verify', $payment) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin memverifikasi pembayaran ini?')">
                                                                <i class="bi bi-check" style="font-size: 1rem; line-height: 1;"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('payments.reject', $payment) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                                                <i class="bi bi-x" style="font-size: 1rem; line-height: 1;"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                                            <i class="bi bi-trash" style="font-size: 1rem; line-height: 1;"></i>
                                                        </button>
                                                    </form>
                                                @endhasanyrole
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data pembayaran</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection