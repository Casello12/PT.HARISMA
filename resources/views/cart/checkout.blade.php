@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-credit-card me-2 text-success"></i>
                        Checkout
                    </h1>
                    <p class="text-muted mb-0">Lengkapi detail pesanan Anda</p>
                </div>
                <a href="{{ route('cart.view') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>

    <form id="checkout-form" method="POST" action="{{ route('cart.checkout.process') }}">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Shipping Information -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-geo-alt me-2"></i>Informasi Pengiriman
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman *</label>
                            <textarea class="form-control" name="shipping_address" rows="3" required placeholder="Masukkan alamat lengkap pengiriman">{{ auth()->user()->address ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Tambahkan catatan untuk pesanan Anda"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-wallet me-2"></i>Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check payment-option-card">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" checked>
                                    <label class="form-check-label payment-option-label" for="payment_cash">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-cash-coin me-2 text-success" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <div class="fw-semibold">Tunai (COD)</div>
                                                <div class="text-muted small">Bayar saat barang diterima</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check payment-option-card">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_transfer" value="transfer">
                                    <label class="form-check-label payment-option-label" for="payment_transfer">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-bank me-2 text-primary" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <div class="fw-semibold">Transfer Bank</div>
                                                <div class="text-muted small">Transfer ke rekening perusahaan</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check payment-option-card">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_credit_card" value="credit_card">
                                    <label class="form-check-label payment-option-label" for="payment_credit_card">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-credit-card me-2 text-warning" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <div class="fw-semibold">Kartu Kredit</div>
                                                <div class="text-muted small">Bayar dengan kartu kredit</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check payment-option-card">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_ewallet" value="ewallet">
                                    <label class="form-check-label payment-option-label" for="payment_ewallet">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-phone me-2 text-info" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <div class="fw-semibold">E-Wallet</div>
                                                <div class="text-muted small">GoPay, OVO, Dana, dll</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-list-check me-2"></i>Item Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="product-image-placeholder me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-box-seam text-muted" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-0">{{ $item->product->name }}</h6>
                                        <p class="text-muted small mb-0">{{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">Ringkasan Pembayaran</h5>
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
                            <span class="fw-bold">Total Pembayaran</span>
                            <span class="fw-bold text-success fs-5">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg process-checkout-btn">
                            <i class="bi bi-check-circle me-1"></i> Proses Pesanan
                        </button>
                        <p class="text-muted small text-center mt-3 mb-0">
                            Dengan menekan tombol "Proses Pesanan", Anda menyetujui syarat dan ketentuan yang berlaku.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.payment-option-card {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-option-card:hover {
    border-color: #28a745;
    background-color: #f8fff9;
}

.payment-option-card input:checked + .payment-option-label {
    color: #28a745;
}

.payment-option-card input:checked ~ .payment-option-label {
    color: #28a745;
}

.payment-option-card input:checked {
    border-color: #28a745;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
    
    // Handle checkout form submission
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', handleCheckout);
    }
});

// Handle checkout form submission
function handleCheckout(e) {
    e.preventDefault();
    
    const btn = document.querySelector('.process-checkout-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Memproses...';
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    fetch(e.target.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            
            setTimeout(() => {
                window.location.href = '{{ route('customer.orders') }}';
            }, 1500);
        } else {
            showToast(data.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Proses Pesanan';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat memproses pesanan', 'error');
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Proses Pesanan';
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