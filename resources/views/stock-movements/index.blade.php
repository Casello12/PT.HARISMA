@extends('layouts.app')

@section('title', 'Pergerakan Stok')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-arrow-left-right me-2"></i>
                    Pergerakan Stok
                </h1>
                <a href="{{ route('stock-movements.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Catat Pergerakan
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h5 class="mb-0">Riwayat Pergerakan Stok</h5>
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
                            <select class="form-select" id="filterType">
                                <option value="">Semua Tipe</option>
                                <option value="in">Masuk</option>
                                <option value="out">Keluar</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Referensi</th>
                                    <th>Tanggal</th>
                                    <th>Gudang</th>
                                    <th>Produk</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Sebelum</th>
                                    <th>Sesudah</th>
                                    <th>Biaya</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockMovements as $index => $movement)
                                    <tr>
                                        <td>{{ ($stockMovements->currentPage() - 1) * $stockMovements->perPage() + $index + 1 }}</td>
                                        <td><code>{{ $movement->reference_number }}</code></td>
                                        <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                                        <td>{{ $movement->warehouse->name }}</td>
                                        <td>{{ $movement->product->name }}</td>
                                        <td>
                                            @if($movement->type === 'in')
                                                <span class="badge bg-success">Masuk</span>
                                            @elseif($movement->type === 'out')
                                                <span class="badge bg-danger">Keluar</span>
                                            @else
                                                <span class="badge bg-primary">Transfer</span>
                                            @endif
                                        </td>
                                        <td>{{ $movement->quantity }}</td>
                                        <td>{{ $movement->before_quantity }}</td>
                                        <td>{{ $movement->after_quantity }}</td>
                                        <td>Rp {{ number_format($movement->total_cost, 0, ',', '.') }}</td>
                                        <td>{{ $movement->createdBy->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <p class="text-muted mb-0">Tidak ada data pergerakan stok</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $stockMovements->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection