@extends('layouts.app')

@section('title', 'Pengingat Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-bell me-2"></i>
                    Pengingat Pembayaran
                </h1>
                <div>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
                        <i class="bi bi-send me-1"></i> Kirim Pengingat Bulk
                    </button>
                    <a href="{{ route('payment-reminders.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg me-1"></i> Kirim Pengingat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Invoice Jatuh Tempo</h5>
                    <h3 class="card-text">{{ $overdueInvoices->total() }} Invoice</h3>
                    <div class="realtime-indicator mt-2"></div>
                    <small>Realtime update</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Invoice Akan Jatuh Tempo (7 Hari)</h5>
                    <h3 class="card-text">{{ $upcomingInvoices->total() }} Invoice</h3>
                    <div class="realtime-indicator mt-2"></div>
                    <small>Realtime update</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Invoice Jatuh Tempo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Customer</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Sisa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overdueInvoices as $invoice)
                                    <tr>
                                        <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td>{{ $invoice->due_date->format('d-m-Y') }}</td>
                                        <td><strong>Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <a href="{{ route('payment-reminders.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-bell"></i> Kirim
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada invoice jatuh tempo</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Invoice Akan Jatuh Tempo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Customer</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Sisa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingInvoices as $invoice)
                                    <tr>
                                        <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td>{{ $invoice->due_date->format('d-m-Y') }}</td>
                                        <td><strong>Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <a href="{{ route('payment-reminders.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-bell"></i> Kirim
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada invoice yang akan jatuh tempo</p>
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

<!-- Bulk Reminder Modal -->
<div class="modal fade" id="bulkReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Pengingat Bulk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('payment-reminders.bulk') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reminder_type" class="form-label">Tipe Pengingat</label>
                        <select class="form-select" id="reminder_type" name="reminder_type" required>
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filter" class="form-label">Filter Invoice</label>
                        <select class="form-select" id="filter" name="filter" required>
                            <option value="overdue">Jatuh Tempo</option>
                            <option value="upcoming">Akan Jatuh Tempo (7 Hari)</option>
                            <option value="all">Semua Invoice Belum Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send me-1"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.realtime-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: {{ $overdueInvoices->total() > 0 ? '#fff' : '#000' }};
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
</style>

<script>
// Realtime payment reminder update
function updateReminderData() {
    fetch('/payment-reminders/realtime')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update overdue count
                const overdueElement = document.querySelector('.bg-danger .card-text');
                if (overdueElement) {
                    overdueElement.textContent = data.overdue_count + ' Invoice';
                }
                
                // Update upcoming count
                const upcomingElement = document.querySelector('.bg-warning .card-text');
                if (upcomingElement) {
                    upcomingElement.textContent = data.upcoming_count + ' Invoice';
                }
                
                console.log('Payment reminders updated:', data.last_updated);
            }
        })
        .catch(error => console.error('Error updating reminder data:', error));
}

// Update every 30 seconds
setInterval(updateReminderData, 30000);
// Initial load
updateReminderData();
</script>
@endsection