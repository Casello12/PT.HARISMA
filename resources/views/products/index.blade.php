@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-box me-2 text-success"></i>
                        Produk
                    </h1>
                    <p class="text-muted mb-0">Daftar produk untuk sales order</p>
                </div>
                <div>
                    <a href="{{ route('products.scanner') }}" class="btn btn-primary">
                        <i class="bi bi-upc-scan me-1"></i> Barcode Scanner
                    </a>
                    @role('admin')
                        <a href="{{ route('products.create') }}" class="btn btn-success ms-2">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                        </a>
                    @endrole
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
                            <h5 class="mb-0 fw-semibold">Daftar Produk</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari produk..." id="search">
                                <button class="btn btn-outline-success" type="button">
                                    <i class="bi bi-search"></i>
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
                                    <th>SKU</th>
                                    <th>Barcode</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Brand</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $index => $product)
                                    <tr>
                                        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $product->sku }}</code></td>
                                        <td>
                                            @if($product->barcode)
                                                <code>{{ $product->barcode }}</code>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'rounded me-2 bg-light d-flex align-items-center justify-content-center\' style=\'width: 40px; height: 40px;\'><i class=\'bi bi-box text-muted\'></i></div>'">
                                                @else
                                                    <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-medium">{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>{{ $product->brand->name ?? '-' }}</td>
                                        <td class="fw-semibold text-success">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $product->warehouseStocks->sum('quantity') ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success-subtle text-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @role('admin')
                                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endrole
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data produk</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection