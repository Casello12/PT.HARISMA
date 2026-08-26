@extends('layouts.app')

@section('title', 'Edit Sales Order')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Sales Order
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
                    <form method="POST" action="{{ route('sales-orders.update', $salesOrder) }}" id="salesOrderForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror" 
                                            id="customer_id" name="customer_id" required>
                                        <option value="">Pilih Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $salesOrder->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="sales_id" class="form-label">Sales</label>
                                    <select class="form-select @error('sales_id') is-invalid @enderror" 
                                            id="sales_id" name="sales_id">
                                        <option value="">Pilih Sales</option>
                                        @foreach($sales as $sale)
                                            <option value="{{ $sale->id }}" {{ old('sales_id', $salesOrder->sales_id) == $sale->id ? 'selected' : '' }}>
                                                {{ $sale->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sales_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="warehouse_id" class="form-label">Gudang</label>
                                    <select class="form-select @error('warehouse_id') is-invalid @enderror" 
                                            id="warehouse_id" name="warehouse_id">
                                        <option value="">Pilih Gudang</option>
                                        @foreach($warehouses ?? [] as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $salesOrder->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="order_date" class="form-label">Tanggal Order <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                                           id="order_date" name="order_date" value="{{ old('order_date', $salesOrder->order_date->format('Y-m-d')) }}" required>
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="required_date" class="form-label">Tanggal Diperlukan</label>
                                    <input type="date" class="form-control @error('required_date') is-invalid @enderror" 
                                           id="required_date" name="required_date" value="{{ old('required_date', $salesOrder->required_date ? $salesOrder->required_date->format('Y-m-d') : '') }}">
                                    @error('required_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="draft" {{ old('status', $salesOrder->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="pending_confirmation" {{ old('status', $salesOrder->status) == 'pending_confirmation' ? 'selected' : '' }}>Pending Confirmation</option>
                                        <option value="confirmed" {{ old('status', $salesOrder->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="awaiting_payment" {{ old('status', $salesOrder->status) == 'awaiting_payment' ? 'selected' : '' }}>Awaiting Payment</option>
                                        <option value="payment_verified" {{ old('status', $salesOrder->status) == 'payment_verified' ? 'selected' : '' }}>Payment Verified</option>
                                        <option value="processing" {{ old('status', $salesOrder->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="packing" {{ old('status', $salesOrder->status) == 'packing' ? 'selected' : '' }}>Packing</option>
                                        <option value="ready_to_ship" {{ old('status', $salesOrder->status) == 'ready_to_ship' ? 'selected' : '' }}>Ready to Ship</option>
                                        <option value="shipped" {{ old('status', $salesOrder->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="in_transit" {{ old('status', $salesOrder->status) == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ old('status', $salesOrder->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="completed" {{ old('status', $salesOrder->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status', $salesOrder->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="discount_amount" class="form-label">Diskon (Rp)</label>
                                            <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" 
                                                   id="discount_amount" name="discount_amount" value="{{ old('discount_amount', $salesOrder->discount_amount) }}" min="0" step="0.01">
                                            @error('discount_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="discount_percentage" class="form-label">Diskon (%)</label>
                                            <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror" 
                                                   id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', $salesOrder->discount_percentage) }}" min="0" max="100" step="0.01">
                                            @error('discount_percentage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tax_amount" class="form-label">Pajak (Rp)</label>
                                            <input type="number" class="form-control @error('tax_amount') is-invalid @enderror" 
                                                   id="tax_amount" name="tax_amount" value="{{ old('tax_amount', $salesOrder->tax_amount) }}" min="0" step="0.01">
                                            @error('tax_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tax_percentage" class="form-label">Pajak (%)</label>
                                            <input type="number" class="form-control @error('tax_percentage') is-invalid @enderror" 
                                                   id="tax_percentage" name="tax_percentage" value="{{ old('tax_percentage', $salesOrder->tax_percentage) }}" min="0" max="100" step="0.01">
                                            @error('tax_percentage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="shipping_cost" class="form-label">Biaya Pengiriman</label>
                                    <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" 
                                           id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost', $salesOrder->shipping_cost) }}" min="0" step="0.01">
                                    @error('shipping_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                              id="shipping_address" name="shipping_address" rows="2">{{ old('shipping_address', $salesOrder->shipping_address) }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_address" class="form-label">Alamat Tagihan</label>
                                    <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                              id="billing_address" name="billing_address" rows="2">{{ old('billing_address', $salesOrder->billing_address) }}</textarea>
                                    @error('billing_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_notes" class="form-label">Catatan Customer</label>
                                    <textarea class="form-control @error('customer_notes') is-invalid @enderror" 
                                              id="customer_notes" name="customer_notes" rows="2">{{ old('customer_notes', $salesOrder->customer_notes) }}</textarea>
                                    @error('customer_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="internal_notes" class="form-label">Catatan Internal</label>
                                    <textarea class="form-control @error('internal_notes') is-invalid @enderror" 
                                              id="internal_notes" name="internal_notes" rows="2">{{ old('internal_notes', $salesOrder->internal_notes) }}</textarea>
                                    @error('internal_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Item Produk</h5>
                                <button type="button" class="btn btn-sm btn-success" onclick="addItem()">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Item
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Produk</th>
                                            <th style="width: 10%">Qty</th>
                                            <th style="width: 15%">Harga Satuan</th>
                                            <th style="width: 10%">Diskon (Rp)</th>
                                            <th style="width: 10%">Diskon (%)</th>
                                            <th style="width: 10%">Pajak (Rp)</th>
                                            <th style="width: 10%">Pajak (%)</th>
                                            <th style="width: 5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        @foreach($salesOrder->items as $index => $item)
                                            @php
                                                $itemCount = $index + 1;
                                            @endphp
                                            <tr id="itemRow{{ $itemCount }}">
                                                <td>
                                                    <select class="form-select product-select" name="items[{{ $itemCount }}][product_id]" required onchange="updateItemPrice({{ $itemCount }})">
                                                        <option value="">Pilih Produk</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} - Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control quantity-input" name="items[{{ $itemCount }}][quantity]" value="{{ $item->quantity }}" min="1" required onchange="calculateTotals()">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control price-input" name="items[{{ $itemCount }}][unit_price]" value="{{ $item->unit_price }}" min="0" step="0.01" required onchange="calculateTotals()">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control discount-amount-input" name="items[{{ $itemCount }}][discount_amount]" value="{{ $item->discount_amount }}" min="0" step="0.01" onchange="calculateTotals()">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control discount-percentage-input" name="items[{{ $itemCount }}][discount_percentage]" value="{{ $item->discount_percentage }}" min="0" max="100" step="0.01" onchange="calculateTotals()">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control tax-amount-input" name="items[{{ $itemCount }}][tax_amount]" value="{{ $item->tax_amount }}" min="0" step="0.01" onchange="calculateTotals()">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control tax-percentage-input" name="items[{{ $itemCount }}][tax_percentage]" value="{{ $item->tax_percentage }}" min="0" max="100" step="0.01" onchange="calculateTotals()">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItem({{ $itemCount }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="displaySubtotal">Rp {{ number_format($salesOrder->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Diskon:</span>
                                            <span id="displayDiscount">Rp {{ number_format($salesOrder->discount_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Pajak:</span>
                                            <span id="displayTax">Rp {{ number_format($salesOrder->tax_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Biaya Pengiriman:</span>
                                            <span id="displayShipping">Rp {{ number_format($salesOrder->shipping_cost, 0, ',', '.') }}</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total:</span>
                                            <span id="displayTotal">Rp {{ number_format($salesOrder->grand_total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="subtotal" name="subtotal" value="{{ $salesOrder->subtotal }}">
                        <input type="hidden" id="grand_total" name="grand_total" value="{{ $salesOrder->grand_total }}">
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('sales-orders.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let itemCount = {{ $salesOrder->items->count() }};
const products = @json($products);

function addItem() {
    itemCount++;
    const tbody = document.getElementById('itemsTableBody');
    const row = document.createElement('tr');
    row.id = 'itemRow' + itemCount;
    
    let productOptions = '<option value="">Pilih Produk</option>';
    products.forEach(product => {
        productOptions += `<option value="${product.id}" data-price="${product.selling_price}">${product.name} - Rp ${product.selling_price.toLocaleString('id-ID')}</option>`;
    });
    
    row.innerHTML = `
        <td>
            <select class="form-select product-select" name="items[${itemCount}][product_id]" required onchange="updateItemPrice(${itemCount})">
                ${productOptions}
            </select>
        </td>
        <td>
            <input type="number" class="form-control quantity-input" name="items[${itemCount}][quantity]" value="1" min="1" required onchange="calculateTotals()">
        </td>
        <td>
            <input type="number" class="form-control price-input" name="items[${itemCount}][unit_price]" value="0" min="0" step="0.01" required onchange="calculateTotals()">
        </td>
        <td>
            <input type="number" class="form-control discount-amount-input" name="items[${itemCount}][discount_amount]" value="0" min="0" step="0.01" onchange="calculateTotals()">
        </td>
        <td>
            <input type="number" class="form-control discount-percentage-input" name="items[${itemCount}][discount_percentage]" value="0" min="0" max="100" step="0.01" onchange="calculateTotals()">
        </td>
        <td>
            <input type="number" class="form-control tax-amount-input" name="items[${itemCount}][tax_amount]" value="0" min="0" step="0.01" onchange="calculateTotals()">
        </td>
        <td>
            <input type="number" class="form-control tax-percentage-input" name="items[${itemCount}][tax_percentage]" value="0" min="0" max="100" step="0.01" onchange="calculateTotals()">
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${itemCount})">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(row);
}

function removeItem(id) {
    const row = document.getElementById('itemRow' + id);
    if (row) {
        row.remove();
        calculateTotals();
    }
}

function updateItemPrice(id) {
    const select = document.querySelector(`#itemRow${id} .product-select`);
    const priceInput = document.querySelector(`#itemRow${id} .price-input`);
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption && selectedOption.dataset.price) {
        priceInput.value = selectedOption.dataset.price;
        calculateTotals();
    }
}

function calculateTotals() {
    let subtotal = 0;
    let totalDiscount = 0;
    let totalTax = 0;
    
    const rows = document.querySelectorAll('#itemsTableBody tr');
    rows.forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const discountAmount = parseFloat(row.querySelector('.discount-amount-input').value) || 0;
        const discountPercentage = parseFloat(row.querySelector('.discount-percentage-input').value) || 0;
        const taxAmount = parseFloat(row.querySelector('.tax-amount-input').value) || 0;
        const taxPercentage = parseFloat(row.querySelector('.tax-percentage-input').value) || 0;
        
        const itemSubtotal = quantity * price;
        const itemDiscount = discountAmount + (itemSubtotal * discountPercentage / 100);
        const itemTax = taxAmount + ((itemSubtotal - itemDiscount) * taxPercentage / 100);
        
        subtotal += itemSubtotal;
        totalDiscount += itemDiscount;
        totalTax += itemTax;
    });
    
    const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
    const orderDiscountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
    const orderDiscountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;
    const orderTaxAmount = parseFloat(document.getElementById('tax_amount').value) || 0;
    const orderTaxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
    
    const finalDiscount = totalDiscount + orderDiscountAmount + (subtotal * orderDiscountPercentage / 100);
    const finalTax = totalTax + orderTaxAmount + ((subtotal - finalDiscount) * orderTaxPercentage / 100);
    const total = subtotal - finalDiscount + finalTax + shippingCost;
    
    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('grand_total').value = total.toFixed(2);
    
    document.getElementById('displaySubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('displayDiscount').textContent = 'Rp ' + finalDiscount.toLocaleString('id-ID');
    document.getElementById('displayTax').textContent = 'Rp ' + finalTax.toLocaleString('id-ID');
    document.getElementById('displayShipping').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
    document.getElementById('displayTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Add event listeners for automatic recalculation
document.getElementById('discount_amount').addEventListener('input', calculateTotals);
document.getElementById('discount_percentage').addEventListener('input', calculateTotals);
document.getElementById('tax_amount').addEventListener('input', calculateTotals);
document.getElementById('tax_percentage').addEventListener('input', calculateTotals);
document.getElementById('shipping_cost').addEventListener('input', calculateTotals);

// Initialize calculations
calculateTotals();
</script>
@endsection