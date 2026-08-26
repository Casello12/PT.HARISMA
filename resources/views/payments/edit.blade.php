@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Pembayaran
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
                    <form method="POST" action="{{ route('payments.update', $payment) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="invoice_id" class="form-label">Invoice <span class="text-danger">*</span></label>
                                    <select class="form-select @error('invoice_id') is-invalid @enderror" 
                                            id="invoice_id" name="invoice_id" required onchange="loadInvoiceDetails()">
                                        <option value="">Pilih Invoice</option>
                                        @foreach($invoices as $invoice)
                                            <option value="{{ $invoice->id }}" 
                                                    data-remaining="{{ $invoice->remaining_amount }}"
                                                    data-customer="{{ $invoice->customer->name }}"
                                                    {{ old('invoice_id', $payment->invoice_id) == $invoice->id ? 'selected' : '' }}>
                                                {{ $invoice->invoice_number }} - {{ $invoice->customer->name }} (Sisa: Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('invoice_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="payment_date" class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                           id="payment_date" name="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" 
                                            id="payment_method" name="payment_method" required onchange="toggleBankFields()">
                                        <option value="">Pilih Metode</option>
                                        <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ old('payment_method', $payment->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="debit_card" {{ old('payment_method', $payment->payment_method) == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                        <option value="check" {{ old('payment_method', $payment->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                                        <option value="other" {{ old('payment_method', $payment->payment_method) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" min="0" step="0.01" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Sisa yang harus dibayar: <span id="remainingAmount">Rp 0</span></small>
                                </div>
                                
                                <div class="mb-3" id="bankFields" style="display: none;">
                                    <label for="bank_name" class="form-label">Nama Bank</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                           id="bank_name" name="bank_name" value="{{ old('bank_name', $payment->bank_name) }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3" id="accountFields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="account_number" class="form-label">Nomor Rekening</label>
                                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                                   id="account_number" name="account_number" value="{{ old('account_number', $payment->account_number) }}">
                                            @error('account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="account_name" class="form-label">Nama Pemilik</label>
                                            <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                                                   id="account_name" name="account_name" value="{{ old('account_name', $payment->account_name) }}">
                                            @error('account_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reference_number" class="form-label">Nomor Referensi</label>
                                    <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                           id="reference_number" name="reference_number" value="{{ old('reference_number', $payment->reference_number) }}">
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="verified" {{ old('status', $payment->status) == 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="rejected" {{ old('status', $payment->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="2">{{ old('notes', $payment->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadInvoiceDetails() {
    const select = document.getElementById('invoice_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption && selectedOption.dataset.remaining) {
        const remaining = parseFloat(selectedOption.dataset.remaining);
        document.getElementById('remainingAmount').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
        document.getElementById('amount').max = remaining;
    }
}

function toggleBankFields() {
    const method = document.getElementById('payment_method').value;
    const bankFields = document.getElementById('bankFields');
    const accountFields = document.getElementById('accountFields');
    
    if (method === 'transfer' || method === 'credit_card' || method === 'debit_card' || method === 'check') {
        bankFields.style.display = 'block';
        accountFields.style.display = 'block';
    } else {
        bankFields.style.display = 'none';
        accountFields.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadInvoiceDetails();
    toggleBankFields();
});
</script>
@endsection