@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-cart me-2 text-success"></i>
                        Keranjang Belanja
                    </h1>
                    <p class="text-muted mb-0">{{ $totalQuantity }} item dalam keranjang</p>
                </div>
                <a href="{{ route('customer.catalog') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                </a>
            </div>
        </div>
    </div>

    @if($cartItems->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Keranjang Anda kosong</h4>
                    <p class="text-muted mb-4">Tambahkan produk ke keranjang untuk mulai berbelanja</p>
                    <a href="{{ route('customer.catalog') }}" class="btn btn-success">
                        <i class="bi bi-grid me-1"></i> Lihat Katalog Produk
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">Item Keranjang</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="cart-item row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-2">
                                    <div class="product-image-placeholder" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-box-seam text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-semibold mb-1">{{ $item->product->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $item->product->category->name ?? '-' }}</p>
                                    <p class="text-success fw-semibold mb-0">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="max-width: 120px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" class="form-control form-control-sm text-center cart-quantity-input" data-cart-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="fw-bold text-success mb-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-sm btn-outline-danger remove-item-btn" data-cart-id="{{ $item->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pajak (0%)</span>
                            <span class="fw-semibold">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span class="fw-semibold">Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-success fs-5">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-success w-100 btn-lg">
                            <i class="bi bi-credit-card me-1"></i> Lanjut ke Pembayaran
                        </a>
                        <button class="btn btn-outline-danger w-100 mt-2 clear-cart-btn">
                            <i class="bi bi-trash me-1"></i> Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
    
    // Attach event listeners
    const removeButtons = document.querySelectorAll('.remove-item-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', handleRemoveItem);
    });
    
    const clearCartButton = document.querySelector('.clear-cart-btn');
    if (clearCartButton) {
        clearCartButton.addEventListener('click', handleClearCart);
    }
});

// Update quantity
function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) return;
    
    fetch(`/cart/${cartId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat mengupdate quantity', 'error');
    });
}

// Remove item handler
function handleRemoveItem(e) {
    const cartId = e.currentTarget.getAttribute('data-cart-id');
    
    if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        return;
    }
    
    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat menghapus item', 'error');
    });
}

// Clear cart handler
function handleClearCart() {
    if (!confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
        return;
    }
    
    fetch('{{ route("cart.clear") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat mengosongkan keranjang', 'error');
    });
}

// Update cart badge
function updateCartBadge() {
    fetch('{{ route("cart.index") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartCount = data.total_quantity || 0;
            const cartBadges = document.querySelectorAll('.cart-badge');
            
            cartBadges.forEach(badge => {
                badge.textContent = cartCount;
                if (cartCount > 0) {
                    badge.classList.remove('d-none');
                    badge.style.display = 'inline-block';
                } else {
                    badge.classList.add('d-none');
                    badge.style.display = 'none';
                }
            });
        }
    })
    .catch(error => {
        console.error('Error updating cart badge:', error);
    });
}

// Show toast notification
function showToast(message, type) {
    const toastClass = type === 'success' ? 'bg-success' : 'bg-danger';
    const toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    toastContainer.style.zIndex = '11';
    
    const toast = document.createElement('div');
    toast.className = `toast show ${toastClass} text-white`;
    toast.setAttribute('role', 'alert');
    
    const toastBody = document.createElement('div');
    toastBody.className = 'toast-body';
    toastBody.textContent = message;
    
    toast.appendChild(toastBody);
    toastContainer.appendChild(toast);
    document.body.appendChild(toastContainer);
    
    setTimeout(() => {
        toastContainer.remove();
    }, 3000);
}
</script>
@endsection