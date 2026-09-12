<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Basic Industry</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; color: #333; }
        .layout { display: flex; min-height: 100vh; } .sidebar { position: fixed; left: 0; top: 0; width: 195px; height: 100vh; padding: 18px 13px; background: #126b7b; color: white; }
        .sidebar-title { margin-bottom: 18px; text-align: center; font-size: 23px; font-weight: normal; } .menu { display: flex; flex-direction: column; gap: 18px; }
        .menu a { display: block; padding: 9px 13px; border: 2px solid #8ed0da; border-radius: 7px; color: white; font-size: 14px; text-decoration: none; }
        .menu a:hover, .menu a.active { background: rgba(255,255,255,0.15); } .logout { position: absolute; right: 13px; bottom: 18px; left: 13px; }
        .logout button { width: 100%; padding: 10px; border: 0; border-radius: 7px; background: #ff1111; color: white; cursor: pointer; }
        .content { flex: 1; min-height: 100vh; margin-left: 195px; padding: 30px 18px; } main { padding: 0; }
        h1 { font-size: 22px; font-weight: normal; } .summary { margin: 20px 0; padding: 15px; background: #126b7a; color: white; }
        table { width: 100%; border-collapse: collapse; } th, td { padding: 9px; border: 1px solid #aaa; text-align: left; } th { background: #f1f1f1; font-weight: normal; }
        .print { display: inline-block; margin-bottom: 18px; padding: 9px 14px; background: #126b7a; color: white; text-decoration: none; }
    </style>
</head>
<body><div class="layout">
    @include('admin.partials.sidebar')
    <main class="content">
    <h1>Laporan Penjualan</h1>
    <a class="print" href="{{ route('admin.reports.print') }}" target="_blank">Cetak Laporan</a>
    <div class="summary">Total penjualan: <strong>Rp {{ number_format($salesTotal, 0, ',', '.') }}</strong></div>
    @if ($transactions->isEmpty())
        <p>Belum ada transaksi.</p>
    @else
        <table><thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th></tr></thead><tbody>
        @foreach ($transactions as $transaction)
            <tr><td>{{ $transaction->transaction_code }}</td><td>{{ $transaction->customer?->name ?? 'Umum' }}</td><td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td><td>{{ $transaction->payment_method }}</td></tr>
        @endforeach
        </tbody></table>
    @endif
</main></div></body>
</html>