@extends('layouts.app')

@section('title', 'Gudang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-house me-2"></i>
                    Gudang
                </h1>
                <a href="{{ route('warehouses.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Gudang
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Daftar Gudang</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari gudang..." id="search">
                                <button class="btn btn-outline-success" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Manager</th>
                                    <th>Telepon</th>
                                    <th>Main</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouses as $index => $warehouse)
                                    <tr>
                                        <td>{{ ($warehouses->currentPage() - 1) * $warehouses->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $warehouse->code }}</code></td>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->city ?? '-' }}, {{ $warehouse->province ?? '-' }}</td>
                                        <td>{{ $warehouse->manager_name ?? '-' }}</td>
                                        <td>{{ $warehouse->manager_phone ?? '-' }}</td>
                                        <td>
                                            @if($warehouse->is_main)
                                                <span class="badge bg-primary">Utama</span>
                                            @else
                                                <span class="badge bg-secondary">Cabang</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($warehouse->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gudang ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data gudang</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $warehouses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection