@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-sliders"></i> Pengaturan</h5>
                    <form action="{{ route('settings.reset') }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-light btn-sm" onclick="return confirm('Apakah Anda yakin ingin mereset pengaturan ke default?')">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset to Default
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="mb-3">Informasi Perusahaan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $settings['company_name']) }}" required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_email" class="form-label">Email Perusahaan</label>
                                    <input type="email" class="form-control @error('company_email') is-invalid @enderror" id="company_email" name="company_email" value="{{ old('company_email', $settings['company_email']) }}">
                                    @error('company_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_phone" class="form-label">Telepon Perusahaan</label>
                                    <input type="text" class="form-control @error('company_phone') is-invalid @enderror" id="company_phone" name="company_phone" value="{{ old('company_phone', $settings['company_phone']) }}">
                                    @error('company_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_logo" class="form-label">URL Logo Perusahaan</label>
                                    <input type="text" class="form-control @error('company_logo') is-invalid @enderror" id="company_logo" name="company_logo" value="{{ old('company_logo', $settings['company_logo']) }}">
                                    @error('company_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="company_address" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" rows="3">{{ old('company_address', $settings['company_address']) }}</textarea>
                            @error('company_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6 class="mb-3">Pengaturan Keuangan</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label">Pajak (%) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tax_rate') is-invalid @enderror" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate']) }}" required>
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Mata Uang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" value="{{ old('currency', $settings['currency']) }}" required>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="payment_due_days" class="form-label">Jatuh Tempo Pembayaran (Hari) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('payment_due_days') is-invalid @enderror" id="payment_due_days" name="payment_due_days" value="{{ old('payment_due_days', $settings['payment_due_days']) }}" required>
                                    @error('payment_due_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Pengaturan Tanggal & Waktu</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_format" class="form-label">Format Tanggal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('date_format') is-invalid @enderror" id="date_format" name="date_format" value="{{ old('date_format', $settings['date_format']) }}" required>
                                    @error('date_format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="time_format" class="form-label">Format Waktu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('time_format') is-invalid @enderror" id="time_format" name="time_format" value="{{ old('time_format', $settings['time_format']) }}" required>
                                    @error('time_format')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">Timezone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('timezone') is-invalid @enderror" id="timezone" name="timezone" value="{{ old('timezone', $settings['timezone']) }}" required>
                                    @error('timezone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Pengaturan Notifikasi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_notifications_enabled" name="email_notifications_enabled" {{ $settings['email_notifications_enabled'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications_enabled">
                                            Aktifkan Notifikasi Email
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sms_notifications_enabled" name="sms_notifications_enabled" {{ $settings['sms_notifications_enabled'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sms_notifications_enabled">
                                            Aktifkan Notifikasi SMS
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Pengaturan Stok</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="low_stock_threshold" class="form-label">Batas Stok Rendah <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $settings['low_stock_threshold']) }}" required>
                                    @error('low_stock_threshold')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
