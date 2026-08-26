@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Produk
                </h1>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
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
                        <div class="col-md-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                                    <i class="bi bi-box text-muted fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $product->name }}</h3>
                            <p class="text-muted mb-4">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">SKU</th>
                                            <td><code>{{ $product->sku }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Barcode</th>
                                            <td>
                                                @if($product->barcode)
                                                    <div class="barcode-container">
                                                        {!! $product->barcode_image !!}
                                                    </div>
                                                    <small class="text-muted">{{ $product->barcode }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kategori</th>
                                            <td>{{ $product->category->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Brand</th>
                                            <td>{{ $product->brand->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Supplier</th>
                                            <td>{{ $product->supplier->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Satuan</th>
                                            <td>{{ $product->unit }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Harga Beli</th>
                                            <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Harga Jual</th>
                                            <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok Minimum</th>
                                            <td>{{ $product->minimum_stock }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok Maximum</th>
                                            <td>{{ $product->maximum_stock }}</td>
                                        </tr>
                                        <tr>
                                            <th>Berat</th>
                                            <td>{{ $product->weight ?? '-' }} kg</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Tanggal Kadaluarsa</th>
                                            <td>{{ $product->expiry_date ? $product->expiry_date->format('d-m-Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Batch</th>
                                            <td>{{ $product->batch_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pajak</th>
                                            <td>{{ $product->tax_rate }}%</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Total Stok</th>
                                            <td>{{ $product->warehouseStocks->sum('quantity') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dibuat Pada</th>
                                            <td>{{ $product->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diperbarui Pada</th>
                                            <td>{{ $product->updated_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            @if($product->notes)
                                <div class="mt-3">
                                    <strong>Catatan:</strong>
                                    <p class="text-muted mb-0">{{ $product->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection