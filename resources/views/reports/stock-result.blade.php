@extends('layouts.app')

@section('title', 'Hasil Laporan Stok')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Hasil Laporan Stok</h5>
                    <form action="{{ route('reports.stock.pdf') }}" method="GET" class="d-inline">
                        @foreach($validated as $key => $value)
                            @if($value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Produk</h6>
                                    <h3 class="card-text">{{ $totalProducts }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Quantity</h6>
                                    <h3 class="card-text">{{ number_format($totalQuantity, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Nilai</h6>
                                    <h3 class="card-text">Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Rata-rata Harga</h6>
                                    <h3 class="card-text">Rp {{ $totalQuantity > 0 ? number_format($totalValue / $totalQuantity, 0, ',', '.') : '0' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Gudang</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Reserved</th>
                                    <th>Available</th>
                                    <th>Harga Rata-rata</th>
                                    <th>Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouseStocks as $stock)
                                    <tr>
                                        <td>{{ $stock->warehouse->name ?? '-' }}</td>
                                        <td>{{ $stock->product->code ?? '-' }}</td>
                                        <td>{{ $stock->product->name ?? '-' }}</td>
                                        <td>{{ $stock->product->category->name ?? '-' }}</td>
                                        <td>{{ $stock->product->brand->name ?? '-' }}</td>
                                        <td>{{ number_format($stock->quantity, 0, ',', '.') }}</td>
                                        <td>{{ number_format($stock->reserved_quantity, 0, ',', '.') }}</td>
                                        <td>{{ number_format($stock->available_quantity, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($stock->average_cost, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($stock->quantity * $stock->average_cost, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('reports.stock.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
