<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
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
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
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
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        .badge-primary {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. Kharisma Sukses Persada</h1>
        <p>Laporan Penjualan</p>
    </div>

    <div class="info">
        <div class="info-row">
            <span class="info-label">Periode:</span>
            <span>{{ \Carbon\Carbon::parse($validated['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($validated['end_date'])->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer:</span>
            <span>{{ $customerName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Sales:</span>
            <span>{{ $salesName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span>{{ $statusText }}</span>
        </div>
    </div>

    <div class="summary">
        <div class="summary-row">
            <span><strong>Total Order:</strong></span>
            <span>{{ $totalOrders }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Pendapatan:</strong></span>
            <span>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Dibayar:</strong></span>
            <span>Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Pending:</strong></span>
            <span>Rp {{ number_format($totalPending, 0, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>Status</th>
                <th class="text-right">Total</th>
                <th class="text-right">Dibayar</th>
                <th class="text-right">Pending</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salesOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td>{{ $order->customer->name ?? '-' }}</td>
                    <td>{{ $order->sales->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $order->status == 'completed' ? 'badge-success' : ($order->status == 'cancelled' ? 'badge-danger' : 'badge-primary') }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td class="text-right">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
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
