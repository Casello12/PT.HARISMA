@extends('layouts.app')

@section('title', 'Detail Sales Order')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Sales Order
                </h1>
                <a href="{{ route('sales-orders.index') }}" class="btn btn-secondary">
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
                                    <th width="30%">Nomor Order</th>
                                    <td><code>{{ $salesOrder->order_number }}</code></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Order</th>
                                    <td>{{ $salesOrder->order_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Diperlukan</th>
                                    <td>{{ $salesOrder->required_date ? $salesOrder->required_date->format('d-m-Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>{{ $salesOrder->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Sales</th>
                                    <td>{{ $salesOrder->sales->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($salesOrder->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @elseif($salesOrder->status === 'pending_confirmation')
                                            <span class="badge bg-warning">Pending Confirmation</span>
                                        @elseif($salesOrder->status === 'confirmed')
                                            <span class="badge bg-info">Confirmed</span>
                                        @elseif($salesOrder->status === 'awaiting_payment')
                                            <span class="badge bg-warning">Awaiting Payment</span>
                                        @elseif($salesOrder->status === 'payment_verified')
                                            <span class="badge bg-success">Payment Verified</span>
                                        @elseif($salesOrder->status === 'processing')
                                            <span class="badge bg-primary">Processing</span>
                                        @elseif($salesOrder->status === 'packing')
                                            <span class="badge bg-primary">Packing</span>
                                        @elseif($salesOrder->status === 'ready_to_ship')
                                            <span class="badge bg-info">Ready to Ship</span>
                                        @elseif($salesOrder->status === 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @elseif($salesOrder->status === 'in_transit')
                                            <span class="badge bg-primary">In Transit</span>
                                        @elseif($salesOrder->status === 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($salesOrder->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($salesOrder->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $salesOrder->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Subtotal</th>
                                    <td>Rp {{ number_format($salesOrder->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Diskon</th>
                                    <td>Rp {{ number_format($salesOrder->discount_amount, 0, ',', '.') }} ({{ $salesOrder->discount_percentage }}%)</td>
                                </tr>
                                <tr>
                                    <th>Pajak</th>
                                    <td>Rp {{ number_format($salesOrder->tax_amount, 0, ',', '.') }} ({{ $salesOrder->tax_percentage }}%)</td>
                                </tr>
                                <tr>
                                    <th>Biaya Pengiriman</th>
                                    <td>Rp {{ number_format($salesOrder->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><strong>Rp {{ number_format($salesOrder->grand_total, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Jumlah Item</th>
                                    <td>{{ $salesOrder->items->count() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($salesOrder->shipping_address)
                        <div class="mt-3">
                            <strong>Alamat Pengiriman:</strong>
                            <p class="text-muted mb-0">{{ $salesOrder->shipping_address }}</p>
                        </div>
                    @endif
                    
                    @if($salesOrder->billing_address)
                        <div class="mt-3">
                            <strong>Alamat Tagihan:</strong>
                            <p class="text-muted mb-0">{{ $salesOrder->billing_address }}</p>
                        </div>
                    @endif
                    
                    @if($salesOrder->customer_notes)
                        <div class="mt-3">
                            <strong>Catatan Customer:</strong>
                            <p class="text-muted mb-0">{{ $salesOrder->customer_notes }}</p>
                        </div>
                    @endif
                    
                    @if($salesOrder->internal_notes)
                        <div class="mt-3">
                            <strong>Catatan Internal:</strong>
                            <p class="text-muted mb-0">{{ $salesOrder->internal_notes }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('sales-orders.edit', $salesOrder) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection