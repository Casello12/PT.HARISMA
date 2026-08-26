@extends('layouts.app')

@section('title', 'Kirim Pengingat Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-plus-circle me-2"></i>
                    Kirim Pengingat Pembayaran
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
                    <form method="POST" action="{{ route('payment-reminders.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="invoice_id" class="form-label">Invoice <span class="text-danger">*</span></label>
                                    <select class="form-select @error('invoice_id') is-invalid @enderror" 
                                            id="invoice_id" name="invoice_id" required>
                                        <option value="">Pilih Invoice</option>
                                        @foreach($invoices as $invoice)
                                            <option value="{{ $invoice->id }}" 
                                                    data-customer="{{ $invoice->customer->name }}"
                                                    data-amount="{{ $invoice->remaining_amount }}"
                                                    data-due="{{ $invoice->due_date->format('d-m-Y') }}"
                                                    {{ old('invoice_id', request()->get('invoice_id')) == $invoice->id ? 'selected' : '' }}>
                                                {{ $invoice->invoice_number }} - {{ $invoice->customer->name }} (Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('invoice_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reminder_type" class="form-label">Tipe Pengingat <span class="text-danger">*</span></label>
                                    <select class="form-select @error('reminder_type') is-invalid @enderror" 
                                            id="reminder_type" name="reminder_type" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="email" {{ old('reminder_type') == 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="sms" {{ old('reminder_type') == 'sms' ? 'selected' : '' }}>SMS</option>
                                        <option value="whatsapp" {{ old('reminder_type') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    </select>
                                    @error('reminder_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="scheduled_date" class="form-label">Jadwal Pengiriman</label>
                                    <input type="date" class="form-control @error('scheduled_date') is-invalid @enderror" 
                                           id="scheduled_date" name="scheduled_date" value="{{ old('scheduled_date') }}">
                                    @error('scheduled_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kosongkan untuk kirim segera</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan Tambahan</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('payment-reminders.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-send me-1"></i> Kirim Pengingat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection