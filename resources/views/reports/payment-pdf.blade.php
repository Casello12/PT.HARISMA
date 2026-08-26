<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran</title>
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
        .badge-warning {
            background: #ffc107;
            color: black;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. Kharisma Sukses Persada</h1>
        <p>Laporan Pembayaran</p>
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
            <span class="info-label">Status:</span>
            <span>{{ $statusText }}</span>
        </div>
    </div>

    <div class="summary">
        <div class="summary-row">
            <span><strong>Total Pembayaran:</strong></span>
            <span>{{ $totalPayments }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Amount:</strong></span>
            <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Verified:</strong></span>
            <span>Rp {{ number_format($totalVerified, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Pending:</strong></span>
            <span>Rp {{ number_format($totalPending, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Rejected:</strong></span>
            <span>Rp {{ number_format($totalRejected, 0, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Pembayaran</th>
                <th>Tanggal</th>
                <th>No. Invoice</th>
                <th>Customer</th>
                <th>Metode</th>
                <th>Status</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                    <td>{{ $payment->invoice->invoice_number ?? '-' }}</td>
                    <td>{{ $payment->invoice->customer->name ?? '-' }}</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>
                        <span class="badge {{ $payment->status == 'verified' ? 'badge-success' : ($payment->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
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
