@extends('layouts.app')

@section('title', 'Piutang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-wallet2 me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Piutang
                    </h1>
                    <p class="text-muted mb-0">Kelola piutang dan hutang customer</p>
                </div>
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
                            <h3 class="card-text fw-bold mb-0">Rp {{ number_format($totalReceivable, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                            <i class="bi bi-wallet2" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white bg-opacity-25">
                            <span class="realtime-indicator"></span> Realtime
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-gradient-danger text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Piutang Jatuh Tempo</h5>
                            <h3 class="card-text fw-bold mb-0">Rp {{ number_format($overdueReceivable, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-shape bg-white bg-opacity-20 text-white rounded-circle p-3">
                            <i class="bi bi-exclamation-triangle" style="font-size: 1.5rem; line-height: 1;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white bg-opacity-25">
                            <span class="realtime-indicator"></span> Realtime
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0 fw-semibold">Piutang per Customer</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari customer..." id="search">
                                <button class="btn btn-outline-success" type="button">
                                    <i class="bi bi-search" style="font-size: 1rem; line-height: 1;"></i>
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
                                    <th>Customer</th>
                                    <th class="text-center">Total Invoice Belum Lunas</th>
                                    <th class="text-end">Jumlah Piutang</th>
                                    <th class="text-center">Jatuh Tempo</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $index => $customer)
                                    <tr>
                                        <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
                                        <td class="fw-medium">{{ $customer->name }}</td>
                                        <td class="text-center">{{ $customer->invoices->where('payment_status', '!=', 'paid')->count() }}</td>
                                        <td class="text-end fw-semibold text-success">Rp {{ number_format($customer->invoices->where('payment_status', '!=', 'paid')->sum('remaining_amount'), 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @php
                                                $overdueInvoices = $customer->invoices->where('payment_status', '!=', 'paid')->where('due_date', '<', now());
                                            @endphp
                                            @if($overdueInvoices->count() > 0)
                                                <span class="badge bg-danger-subtle text-danger">{{ $overdueInvoices->count() }} Jatuh Tempo</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('accounts-receivable.show', $customer) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye" style="font-size: 1rem; line-height: 1;"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data piutang</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.realtime-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: #fff;
    border-radius: 50%;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

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

<script>
// Realtime accounts receivable update
function updateReceivableData() {
    fetch('/accounts-receivable/realtime')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update total receivable
                const totalReceivableElement = document.querySelector('.bg-gradient-success .card-text');
                if (totalReceivableElement) {
                    totalReceivableElement.textContent = 'Rp ' + data.total_receivable.toLocaleString('id-ID');
                }
                
                // Update overdue receivable
                const overdueReceivableElement = document.querySelector('.bg-gradient-danger .card-text');
                if (overdueReceivableElement) {
                    overdueReceivableElement.textContent = 'Rp ' + data.overdue_receivable.toLocaleString('id-ID');
                }
                
                // Update last updated time
                const lastUpdated = new Date(data.last_updated);
                console.log('Last updated:', lastUpdated.toLocaleString('id-ID'));
            }
        })
        .catch(error => console.error('Error updating receivable data:', error));
}

// Update every 30 seconds
setInterval(updateReceivableData, 30000);
// Initial load
updateReceivableData();
</script>
@endsection