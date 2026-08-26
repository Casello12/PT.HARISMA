@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-person me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Profil Saya
                    </h1>
                    <p class="text-muted mb-0">Kelola informasi akun Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="avatar-circle bg-gradient-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 3rem;">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <h4 class="fw-bold mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-3">{{ $customer->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-success-subtle text-success">Customer</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" value="{{ $customer->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $customer->email }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">No. Telepon</label>
                                <input type="text" class="form-control" name="phone" value="{{ $customer->phone ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Alamat</label>
                                <input type="text" class="form-control" name="address" value="{{ $customer->address ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Role</label>
                            <input type="text" class="form-control" value="{{ $customer->roles->first()->name ?? 'Customer' }}" disabled>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1" style="font-size: 1rem; line-height: 1;"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    background: linear-gradient(135deg, #16A34A 0%, #15803D 50%, #166534 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #16A34A 0%, #15803D 50%, #166534 100%);
}
</style>
@endsection
