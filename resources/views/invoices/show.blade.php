@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-eye me-2"></i>
                    Detail Invoice
                </h1>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
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
                                    <th width="30%">Nomor Invoice</th>
                                    <td><code>{{ $invoice->invoice_number }}</code></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Invoice</th>
                                    <td>{{ $invoice->invoice_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <td>{{ $invoice->due_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>{{ $invoice->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Sales Order</th>
                                    <td>{{ $invoice->salesOrder ? $invoice->salesOrder->order_number : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        @if($invoice->payment_status === 'unpaid')
                                            <span class="badge bg-danger">Unpaid</span>
                                        @elseif($invoice->payment_status === 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @elseif($invoice->payment_status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($invoice->payment_status === 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $invoice->payment_status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Subtotal</th>
                                    <td>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Diskon</th>
                                    <td>Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Pajak</th>
                                    <td>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }} ({{ $invoice->tax_percentage }}%)</td>
                                </tr>
                                <tr>
                                    <th>Biaya Pengiriman</th>
                                    <td>Rp {{ number_format($invoice->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><strong>Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Sudah Dibayar</th>
                                    <td>Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Sisa</th>
                                    <td><strong>Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($invoice->billing_address)
                        <div class="mt-3">
                            <strong>Alamat Tagihan:</strong>
                            <p class="text-muted mb-0">{{ $invoice->billing_address }}</p>
                        </div>
                    @endif
                    
                    @if($invoice->notes)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="text-muted mb-0">{{ $invoice->notes }}</p>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <h5 class="mb-3">Item Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                    <th>Diskon</th>
                                    <th>Pajak</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->discount_amount, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->tax_amount, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($invoice->payments->count() > 0)
                        <hr>
                        <h5 class="mb-3">Riwayat Pembayaran</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No. Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>Metode</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->payments as $payment)
                                        <tr>
                                            <td><code>{{ $payment->payment_number }}</code></td>
                                            <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                            <td>{{ ucfirst($payment->payment_method) }}</td>
                                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($payment->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($payment->status === 'verified')
                                                    <span class="badge bg-success">Verified</span>
                                                @elseif($payment->status === 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        @if($invoice->payment_status !== 'paid')
                            <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success">
                                <i class="bi bi-currency-dollar me-1"></i> Tambah Pembayaran
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection