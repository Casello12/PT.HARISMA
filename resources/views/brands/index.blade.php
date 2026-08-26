@extends('layouts.app')

@section('title', 'Brand')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-tag me-2"></i>
                    Brand
                </h1>
                <a href="{{ route('brands.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Brand
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
                            <h5 class="mb-0">Daftar Brand</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari brand..." id="search">
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
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Logo</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Jumlah Produk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brands as $index => $brand)
                                    <tr>
                                        <td>{{ ($brands->currentPage() - 1) * $brands->perPage() + $index + 1 }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td><code>{{ $brand->slug }}</code></td>
                                        <td>
                                            @if($brand->logo)
                                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="img-thumbnail" style="max-width: 50px;" onerror="this.src='{{ asset('images/no-image.png') }}'">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($brand->description, 50) ?? '-' }}</td>
                                        <td>
                                            @if($brand->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $brand->products()->count() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('brands.show', $brand) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus brand ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data brand</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection