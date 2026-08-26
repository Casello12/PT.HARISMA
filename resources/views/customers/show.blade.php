@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Customer
                </h1>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode</th>
                                    <td><code>{{ $customer->code }}</code></td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Person</th>
                                    <td>{{ $customer->contact_person ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $customer->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $customer->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Sales</th>
                                    <td>{{ $customer->sales->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($customer->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Alamat</th>
                                    <td>{{ $customer->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>{{ $customer->city ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $customer->province ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $customer->postal_code ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Credit Limit</th>
                                    <td>Rp {{ number_format($customer->credit_limit, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Terms</th>
                                    <td>{{ $customer->payment_terms }} hari</td>
                                </tr>
                                <tr>
                                    <th>Total Order</th>
                                    <td>{{ $customer->salesOrders()->count() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection