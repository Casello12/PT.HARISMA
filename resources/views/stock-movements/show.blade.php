@extends('layouts.app')

@section('title', 'Detail Pergerakan Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Pergerakan Stok
                </h1>
                <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">
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
                                    <th width="30%">Nomor Referensi</th>
                                    <td><code>{{ $stockMovement->reference_number }}</code></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $stockMovement->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Gudang</th>
                                    <td>{{ $stockMovement->warehouse->name }}</td>
                                </tr>
                                <tr>
                                    <th>Produk</th>
                                    <td>{{ $stockMovement->product->name }}</td>
                                </tr>
                                <tr>
                                    <th>SKU</th>
                                    <td><code>{{ $stockMovement->product->sku }}</code></td>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <td>
                                        @if($stockMovement->type === 'in')
                                            <span class="badge bg-success">Masuk</span>
                                        @elseif($stockMovement->type === 'out')
                                            <span class="badge bg-danger">Keluar</span>
                                        @else
                                            <span class="badge bg-primary">Transfer</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Jumlah</th>
                                    <td>{{ $stockMovement->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Stok Sebelum</th>
                                    <td>{{ $stockMovement->before_quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Stok Sesudah</th>
                                    <td>{{ $stockMovement->after_quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Satuan</th>
                                    <td>Rp {{ number_format($stockMovement->unit_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Biaya</th>
                                    <td>Rp {{ number_format($stockMovement->total_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Oleh</th>
                                    <td>{{ $stockMovement->createdBy->name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($stockMovement->notes)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="text-muted mb-0">{{ $stockMovement->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection