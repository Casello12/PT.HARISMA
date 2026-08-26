@extends('layouts.app')

@section('title', 'Detail Gudang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Gudang
                </h1>
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode</th>
                                    <td><code>{{ $warehouse->code }}</code></td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $warehouse->name }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $warehouse->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>{{ $warehouse->city ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $warehouse->province ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $warehouse->postal_code ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Telepon</th>
                                    <td>{{ $warehouse->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Manager</th>
                                    <td>{{ $warehouse->manager_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon Manager</th>
                                    <td>{{ $warehouse->manager_phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Latitude</th>
                                    <td>{{ $warehouse->latitude ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Longitude</th>
                                    <td>{{ $warehouse->longitude ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($warehouse->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection