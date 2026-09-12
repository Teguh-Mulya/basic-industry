<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; } h1 { text-align: center; font-size: 20px; }
        .total { margin: 20px 0; font-weight: bold; } table { width: 100%; border-collapse: collapse; } th, td { padding: 8px; border: 1px solid #555; text-align: left; } th { background: #eee; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <button class="no-print" type="button" onclick="window.print()">Cetak</button>
    <h1>Laporan Penjualan Basic Industry</h1>
    <p class="total">Total penjualan: Rp {{ number_format($salesTotal, 0, ',', '.') }}</p>
    <table><thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th></tr></thead><tbody>
    @foreach ($transactions as $transaction)
        <tr><td>{{ $transaction->transaction_code }}</td><td>{{ $transaction->customer?->name ?? 'Umum' }}</td><td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td></tr>
    @endforeach
    </tbody></table>
</body>
</html>