@extends('layouts.app')

@section('title', 'Detail Stok Gudang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Stok Gudang
                </h1>
                <a href="{{ route('warehouse-stocks.index') }}" class="btn btn-secondary">
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
                                    <th width="30%">Gudang</th>
                                    <td>{{ $warehouseStock->warehouse->name }}</td>
                                </tr>
                                <tr>
                                    <th>Produk</th>
                                    <td>{{ $warehouseStock->product->name }}</td>
                                </tr>
                                <tr>
                                    <th>SKU</th>
                                    <td><code>{{ $warehouseStock->product->sku }}</code></td>
                                </tr>
                                <tr>
                                    <th>Stok Total</th>
                                    <td>{{ $warehouseStock->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Stok Reserved</th>
                                    <td>{{ $warehouseStock->reserved_quantity }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Stok Available</th>
                                    <td>{{ $warehouseStock->available_quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Average Cost</th>
                                    <td>Rp {{ number_format($warehouseStock->average_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Value</th>
                                    <td>Rp {{ number_format($warehouseStock->quantity * $warehouseStock->average_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Stock In</th>
                                    <td>{{ $warehouseStock->last_stock_in ? $warehouseStock->last_stock_in->format('d-m-Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Last Stock Out</th>
                                    <td>{{ $warehouseStock->last_stock_out ? $warehouseStock->last_stock_out->format('d-m-Y H:i') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('warehouse-stocks.edit', $warehouseStock) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection