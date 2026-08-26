@extends('layouts.app')

@section('title', 'Stok Gudang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-box-seam me-2"></i>
                    Stok Gudang
                </h1>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Stok
                    </button>
                    <a href="{{ route('warehouse-stocks.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg me-1"></i> Buat Stok Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h5 class="mb-0">Daftar Stok Gudang</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterWarehouse">
                                <option value="">Semua Gudang</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gudang</th>
                                    <th>Produk</th>
                                    <th>SKU</th>
                                    <th>Stok Total</th>
                                    <th>Stok Reserved</th>
                                    <th>Stok Available</th>
                                    <th>Average Cost</th>
                                    <th>Total Value</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouseStocks as $index => $stock)
                                    <tr>
                                        <td>{{ ($warehouseStocks->currentPage() - 1) * $warehouseStocks->perPage() + $index + 1 }}</td>
                                        <td>{{ $stock->warehouse->name }}</td>
                                        <td>{{ $stock->product->name }}</td>
                                        <td><code>{{ $stock->product->sku }}</code></td>
                                        <td>
                                            <span class="badge @if($stock->quantity < $stock->product->minimum_stock) bg-danger @else bg-success @endif">
                                                {{ $stock->quantity }}
                                            </span>
                                        </td>
                                        <td>{{ $stock->reserved_quantity }}</td>
                                        <td>{{ $stock->available_quantity }}</td>
                                        <td>Rp {{ number_format($stock->average_cost, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($stock->quantity * $stock->average_cost, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('warehouse-stocks.show', $stock) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('warehouse-stocks.edit', $stock) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('warehouse-stocks.destroy', $stock) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus stok ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data stok gudang</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $warehouseStocks->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('warehouse-stocks.add-stock') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Gudang <span class="text-danger">*</span></label>
                            <select class="form-select" id="warehouse_id" name="warehouse_id" required>
                                <option value="">Pilih Gudang</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                            <select class="form-select" id="product_id" name="product_id" required>
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="unit_cost" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="unit_cost" name="unit_cost" min="0" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="reference_number" class="form-label">Nomor Referensi</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number">
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah Stok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection