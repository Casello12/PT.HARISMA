<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #16A34A;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background: #e8f5e9;
            border-radius: 5px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
        .summary-row:last-child {
            border-bottom: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        th {
            background: #16A34A;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. Kharisma Sukses Persada</h1>
        <p>Laporan Stok</p>
    </div>

    <div class="info">
        <div class="info-row">
            <span class="info-label">Gudang:</span>
            <span>{{ $warehouseName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kategori:</span>
            <span>{{ $categoryName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Produk:</span>
            <span>{{ $productName }}</span>
        </div>
    </div>

    <div class="summary">
        <div class="summary-row">
            <span><strong>Total Produk:</strong></span>
            <span>{{ $totalProducts }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Quantity:</strong></span>
            <span>{{ number_format($totalQuantity, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Nilai:</strong></span>
            <span>Rp {{ number_format($totalValue, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Rata-rata Harga:</strong></span>
            <span>Rp {{ $totalQuantity > 0 ? number_format($totalValue / $totalQuantity, 0, ',', '.') : '0' }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Gudang</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Brand</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Reserved</th>
                <th class="text-right">Available</th>
                <th class="text-right">Harga Rata-rata</th>
                <th class="text-right">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warehouseStocks as $stock)
                <tr>
                    <td>{{ $stock->warehouse->name ?? '-' }}</td>
                    <td>{{ $stock->product->code ?? '-' }}</td>
                    <td>{{ $stock->product->name ?? '-' }}</td>
                    <td>{{ $stock->product->category->name ?? '-' }}</td>
                    <td>{{ $stock->product->brand->name ?? '-' }}</td>
                    <td class="text-right">{{ number_format($stock->quantity, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($stock->reserved_quantity, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($stock->available_quantity, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($stock->average_cost, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($stock->quantity * $stock->average_cost, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>&copy; 2026 PT. Kharisma Sukses Persada</p>
    </div>
</body>
</html>
