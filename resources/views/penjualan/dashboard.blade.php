@include('penjualan.partials.layout-start', ['title' => 'Dashboard Admin Penjualan'])
<style>
    .sales-dashboard-head { display: flex; align-items: end; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
    .sales-dashboard-head h1 { margin-bottom: 6px; }
    .sales-dashboard-head p { margin: 0; color: #607177; font-size: 13px; }
    .sales-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 20px; }
    .sales-stat { padding: 18px; border-left: 4px solid #126b7a; border-radius: 7px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); }
    .sales-stat strong { display: block; margin-bottom: 8px; color: #607177; font-size: 12px; font-weight: normal; }
    .sales-stat span { color: #126b7a; font-size: 24px; font-weight: bold; }
    .sales-dashboard-panel { padding: 18px; border-radius: 8px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); }
    .sales-dashboard-panel h2 { margin: 0 0 14px; font-size: 18px; }
    .sales-chart-panel { margin-bottom: 20px; }
    .sales-chart { width: 100%; height: 120px; display: block; }
    .sales-chart-labels { display: grid; grid-template-columns: repeat(6, 1fr); gap: 4px; margin-top: 5px; text-align: center; }
    .sales-chart-labels span { display: grid; gap: 3px; min-width: 0; color: #607177; font-size: 10px; }
    .sales-chart-labels strong, .sales-chart-labels small { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sales-chart-labels small { color: #126b7a; font-size: 10px; }
    @media (max-width: 850px) { .sales-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 600px) { .sales-dashboard-head { align-items: stretch; flex-direction: column; } .sales-stats { grid-template-columns: 1fr; } }
</style>
<div class="sales-dashboard-head">
    <div>
        <h1>Dashboard</h1>
        <p>Selamat datang, {{ auth()->user()->name }}. Kelola penjualan dan pesanan dari sini.</p>
    </div>
    <a class="sales-button" href="{{ route('penjualan.orders') }}">Kelola Pesanan</a>
</div>
<div class="sales-stats">
    <div class="sales-stat"><strong>Total Transaksi</strong><span>{{ $transactionCount }}</span></div>
    <div class="sales-stat"><strong>Penjualan Hari Ini</strong><span>Rp {{ number_format($todaySales, 0, ',', '.') }}</span></div>
    <div class="sales-stat"><strong>Pelanggan</strong><span>{{ $customerCount }}</span></div>
    <div class="sales-stat"><strong>Produk</strong><span>{{ $productCount }}</span></div>
</div>
<section class="sales-dashboard-panel sales-chart-panel">
    <h2>Grafik Penjualan 6 Bulan Terakhir</h2>
    <svg class="sales-chart" viewBox="0 0 900 100" preserveAspectRatio="none" aria-label="Grafik penjualan enam bulan terakhir">
        <defs><linearGradient id="salesDashboardGradient" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#39ff00" /><stop offset="55%" stop-color="#baff00" /><stop offset="100%" stop-color="#ff1500" /></linearGradient></defs>
        <polygon points="@foreach ($monthlySales as $index => $month){{ $index * 180 }},{{ 90 - (($month['total'] / $monthlySalesMax) * 75) }} @endforeach 900,100 0,100" fill="url(#salesDashboardGradient)" stroke="white" stroke-width="4" />
    </svg>
    <div class="sales-chart-labels">@foreach ($monthlySales as $month)<span><strong>{{ $month['label'] }}</strong><small>Rp {{ number_format($month['total'], 0, ',', '.') }}</small></span>@endforeach</div>
</section>
<section class="sales-dashboard-panel">
    <h2>Transaksi Terbaru</h2>
    <div class="sales-table-wrap">
        <table class="sales-table">
            <thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($transactions as $transaction)
                @php($currentStatus = $transaction->status ?: 'Menunggu Persetujuan')
                <tr>
                    <td>{{ $transaction->transaction_code }}</td>
                    <td>{{ $transaction->customer?->name ?? 'Umum' }}</td>
                    <td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td>
                    <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    <td>{{ $currentStatus }}</td>
                    <td><form class="status-form" action="{{ route('penjualan.orders.status', $transaction) }}" method="POST">@csrf @method('PATCH')<select name="status" aria-label="Status {{ $transaction->transaction_code }}">@foreach (['Menunggu Persetujuan', 'Diproses', 'Dikirim', 'Selesai'] as $status)<option value="{{ $status }}" @selected($currentStatus === $status)>{{ $status }}</option>@endforeach</select><button type="submit">Simpan</button></form></td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@include('penjualan.partials.layout-end')
