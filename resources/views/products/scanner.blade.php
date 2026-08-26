@extends('layouts.app')

@section('title', 'Barcode Scanner')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold">
                        <i class="bi bi-upc-scan me-2 text-success"></i>
                        Barcode Scanner
                    </h1>
                    <p class="text-muted mb-0">Scan barcode produk untuk melihat detail</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Scan Barcode</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="barcodeInput" class="form-label fw-medium">Input Barcode Manual</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="barcodeInput" placeholder="Scan atau ketik barcode..." autofocus>
                            <button class="btn btn-primary" type="button" id="scanBtn">
                                <i class="bi bi-search"></i> Scan
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Atau Gunakan Kamera</label>
                        <div id="scanner-container" style="width: 100%; height: 300px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 0.5rem;">
                            <div class="text-center text-muted">
                                <i class="bi bi-camera" style="font-size: 48px;"></i>
                                <p class="mt-2">Kamera akan aktif di sini</p>
                                <button class="btn btn-outline-primary" id="startCameraBtn">
                                    <i class="bi bi-camera-video"></i> Aktifkan Kamera
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 fw-semibold">Detail Produk</h5>
                </div>
                <div class="card-body" id="productDetails">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-box-seam" style="font-size: 64px;"></i>
                        <p class="mt-3">Scan barcode untuk melihat detail produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const barcodeInput = document.getElementById('barcodeInput');
    const scanBtn = document.getElementById('scanBtn');
    const productDetails = document.getElementById('productDetails');
    const startCameraBtn = document.getElementById('startCameraBtn');
    const scannerContainer = document.getElementById('scanner-container');
    
    // Handle manual barcode input
    barcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            scanBarcode();
        }
    });
    
    scanBtn.addEventListener('click', function() {
        scanBarcode();
    });
    
    function scanBarcode() {
        const barcode = barcodeInput.value.trim();
        if (!barcode) {
            alert('Silakan masukkan barcode');
            return;
        }
        
        fetch('/products/scan-barcode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ barcode: barcode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayProductDetails(data.product);
            } else {
                productDetails.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> ${data.message}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            productDetails.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan saat memindai barcode
                </div>
            `;
        });
    }
    
    function displayProductDetails(product) {
        const stockInfo = product.warehouse_stocks && product.warehouse_stocks.length > 0 
            ? product.warehouse_stocks.map(ws => `
                <tr>
                    <td>${ws.warehouse.name}</td>
                    <td>${ws.quantity}</td>
                    <td>${ws.available_quantity}</td>
                </tr>
            `).join('')
            : '<tr><td colspan="3" class="text-center">Tidak ada data stok</td></tr>';
        
        // Generate barcode HTML using the same library
        const barcodeHtml = product.barcode ? generateBarcodeHTML(product.barcode) : '';
        
        productDetails.innerHTML = `
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    ${product.image 
                        ? `<img src="/storage/${product.image}" alt="${product.name}" class="img-fluid rounded" style="max-height: 150px;">`
                        : `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="bi bi-box-seam text-muted" style="font-size: 48px;"></i>
                           </div>`
                    }
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">SKU</th>
                            <td><code>${product.sku}</code></td>
                        </tr>
                        <tr>
                            <th>Barcode</th>
                            <td>
                                <div class="barcode-container">
                                    ${barcodeHtml}
                                </div>
                                <small class="text-muted">${product.barcode}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Produk</th>
                            <td class="fw-medium">${product.name}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>${product.category ? product.category.name : '-'}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>${product.brand ? product.brand.name : '-'}</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td class="fw-semibold text-success">Rp ${parseFloat(product.selling_price).toLocaleString('id-ID')}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-${product.is_active ? 'success-subtle text-success' : 'secondary-subtle text-secondary'}">
                                    ${product.is_active ? 'Aktif' : 'Tidak Aktif'}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <h6 class="mt-4 fw-semibold">Stok per Gudang</h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Gudang</th>
                            <th>Total Stok</th>
                            <th>Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${stockInfo}
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <a href="/products/${product.id}" class="btn btn-primary">
                    <i class="bi bi-eye"></i> Lihat Detail Lengkap
                </a>
                <button class="btn btn-outline-secondary" onclick="resetScanner()">
                    <i class="bi bi-arrow-counterclockwise"></i> Scan Lagi
                </button>
            </div>
        `;
    }
    
    function generateBarcodeHTML(barcode) {
        // Simple barcode generation using CSS bars
        let html = '<div style="display: flex; align-items: center; justify-content: center; height: 50px; background: white; padding: 5px;">';
        
        // Generate a simple pattern based on barcode string
        for (let i = 0; i < barcode.length; i++) {
            const charCode = barcode.charCodeAt(i);
            const width = (charCode % 3) + 1;
            const isBlack = charCode % 2 === 0;
            html += `<div style="width: ${width}px; height: 40px; background: ${isBlack ? 'black' : 'white'}; margin: 0 1px;"></div>`;
        }
        
        html += '</div>';
        return html;
    }
    
    function resetScanner() {
        barcodeInput.value = '';
        productDetails.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="bi bi-box-seam" style="font-size: 64px;"></i>
                <p class="mt-3">Scan barcode untuk melihat detail produk</p>
            </div>
        `;
        barcodeInput.focus();
    }
    
    // Camera functionality (placeholder - would need additional library like QuaggaJS)
    startCameraBtn.addEventListener('click', function() {
        alert('Fitur kamera memerlukan library tambahan. Gunakan input manual untuk saat ini.');
    });
});
</script>
@endsection
