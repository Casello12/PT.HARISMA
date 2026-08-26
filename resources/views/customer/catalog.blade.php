@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold mb-1">
                        <i class="bi bi-grid me-2 text-success" style="font-size: 1.5rem; line-height: 1;"></i>
                        Katalog Produk
                    </h1>
                    <p class="text-muted mb-0">Temukan produk terbaik untuk kebutuhan Anda</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                        <button class="btn btn-success">
                            <i class="bi bi-search" style="font-size: 1rem; line-height: 1;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <select class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="1">Elektronik</option>
                                <option value="2">Furniture</option>
                                <option value="3">Office Supplies</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option value="">Semua Brand</option>
                                <option value="1">Brand A</option>
                                <option value="2">Brand B</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option value="name">Nama A-Z</option>
                                <option value="price_asc">Harga Terendah</option>
                                <option value="price_desc">Harga Tertinggi</option>
                                <option value="stock">Stok Terbanyak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-funnel me-1" style="font-size: 1rem; line-height: 1;"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="position-relative">
                        <div class="product-image" style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <span class="badge bg-success position-absolute top-0 end-0 m-2">Tersedia</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-light text-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <h5 class="card-title fw-semibold mb-2">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3">{{ $product->brand->name ?? '-' }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-muted small">Stok:</span>
                                <span class="fw-semibold">{{ $product->warehouseStocks->sum('quantity') ?? 0 }}</span>
                            </div>
                            <div class="price-tag">
                                <span class="text-success fw-bold fs-5">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="quantity-selector mb-3">
                            <label class="form-label small text-muted mb-1">Jumlah:</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity({{ $product->id }})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="form-control text-center quantity-input" data-product-id="{{ $product->id }}" value="1" min="1" max="{{ $product->warehouseStocks->sum('quantity') ?? 0 }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity({{ $product->id }}, {{ $product->warehouseStocks->sum('quantity') ?? 0 }})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form" data-product-id="{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" class="form-quantity" value="1">
                            <button type="submit" class="btn btn-success w-100 add-to-cart-btn" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->selling_price }}">
                                <i class="bi bi-cart-plus me-1" style="font-size: 1rem; line-height: 1;"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Tidak ada produk ditemukan</h4>
                    <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12">
            {{ $products->links() }}
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.product-image {
    border-radius: 12px 12px 0 0;
}

.price-tag {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    padding: 8px 16px;
    border-radius: 8px;
}

.quantity-input {
    width: 60px;
}
</style>
@endsection

@section('scripts')
<script>
// Load cart data on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    updateCartBadge();
    
    // Attach event listeners to all add to cart buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    console.log('Found add to cart buttons:', addToCartButtons.length);
    
    addToCartButtons.forEach((button, index) => {
        console.log(`Attaching listener to button ${index}:`, button);
        button.addEventListener('click', function(e) {
            console.log('Button clicked:', e.target);
            handleAddToCart(e);
        });
    });
});

// Increase quantity
function increaseQuantity(productId, maxStock) {
    console.log('Increase quantity called for product:', productId, 'max stock:', maxStock);
    const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
    const formQuantity = document.querySelector(`.add-to-cart-form[data-product-id="${productId}"] .form-quantity`);
    
    if (input) {
        let currentValue = parseInt(input.value);
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
            if (formQuantity) {
                formQuantity.value = currentValue + 1;
            }
        }
    }
}

// Decrease quantity
function decreaseQuantity(productId) {
    console.log('Decrease quantity called for product:', productId);
    const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
    const formQuantity = document.querySelector(`.add-to-cart-form[data-product-id="${productId}"] .form-quantity`);
    
    if (input) {
        let currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            if (formQuantity) {
                formQuantity.value = currentValue - 1;
            }
        }
    }
}

// Add to cart handler
function handleAddToCart(e) {
    console.log('handleAddToCart called');
    e.preventDefault();
    
    const btn = e.currentTarget;
    const productId = btn.getAttribute('data-product-id');
    const quantityInput = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
    
    console.log('Product ID:', productId);
    console.log('Quantity input:', quantityInput);
    
    if (!quantityInput) {
        console.error('Quantity input not found');
        showToast('Input quantity tidak ditemukan', 'error');
        return;
    }
    
    const quantity = parseInt(quantityInput.value);
    console.log('Quantity:', quantity);
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Menambahkan...';
    
    const cartUrl = '{{ route("cart.add") }}';
    console.log('Cart URL:', cartUrl);
    
    fetch(cartUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showToast(data.message, 'success');
            updateCartBadge();
            if (quantityInput) {
                quantityInput.value = 1;
            }
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
    })
    .finally(() => {
        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang';
    });
}

// Update cart badge
function updateCartBadge() {
    console.log('Updating cart badge');
    fetch('{{ route("cart.index") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Cart badge data:', data);
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
    console.log('Showing toast:', message, type);
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