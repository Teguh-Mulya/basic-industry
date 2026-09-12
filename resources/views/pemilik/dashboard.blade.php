@include('pemilik.partials.layout-start', ['title' => 'Dashboard Pemilik'])
<style>
    .owner-dashboard-head { display: flex; align-items: end; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
    .owner-dashboard-head h1 { margin-bottom: 6px; }
    .owner-dashboard-head p { margin: 0; color: #607177; font-size: 13px; }
    .owner-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 20px; }
    .owner-stat { padding: 18px; border-left: 4px solid #126b7a; border-radius: 7px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); }
    .owner-stat strong { display: block; margin-bottom: 8px; color: #607177; font-size: 12px; font-weight: normal; }
    .owner-stat span { color: #126b7a; font-size: 22px; font-weight: bold; }
    .owner-dashboard-panel { padding: 18px; border-radius: 8px; background: #fff; box-shadow: 0 4px 16px rgba(38,50,56,.08); }
    .owner-dashboard-panel h2 { margin: 0 0 14px; font-size: 18px; }
    .owner-chart-panel { margin-bottom: 20px; }
    .owner-chart { width: 100%; height: 120px; display: block; }
    .owner-chart-labels { display: grid; grid-template-columns: repeat(6, 1fr); gap: 4px; margin-top: 5px; text-align: center; }
    .owner-chart-labels span { display: grid; gap: 3px; min-width: 0; color: #607177; font-size: 10px; }
    .owner-chart-labels strong, .owner-chart-labels small { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .owner-chart-labels small { color: #126b7a; font-size: 10px; }
    @media (max-width: 850px) { .owner-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 600px) { .owner-dashboard-head { align-items: stretch; flex-direction: column; } .owner-stats { grid-template-columns: 1fr; } }
</style>
<div class="owner-dashboard-head"><div><h1>Dashboard Pemilik</h1><p>Selamat datang, {{ auth()->user()->name }}. Pantau kinerja bisnis dari sini.</p></div><a class="owner-button" href="{{ route('pemilik.report') }}">Lihat Laporan</a></div>
<div class="owner-stats"><div class="owner-stat"><strong>Produk</strong><span>{{ $productCount }}</span></div><div class="owner-stat"><strong>Total Stok</strong><span>{{ $stockTotal }}</span></div><div class="owner-stat"><strong>Transaksi</strong><span>{{ $transactionCount }}</span></div><div class="owner-stat"><strong>Total Penjualan</strong><span>Rp {{ number_format($salesTotal, 0, ',', '.') }}</span></div></div>
<section class="owner-dashboard-panel owner-chart-panel"><h2>Grafik Penjualan 6 Bulan Terakhir</h2><svg class="owner-chart" viewBox="0 0 900 100" preserveAspectRatio="none" aria-label="Grafik penjualan enam bulan terakhir"><defs><linearGradient id="ownerDashboardGradient" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#39ff00" /><stop offset="55%" stop-color="#baff00" /><stop offset="100%" stop-color="#ff1500" /></linearGradient></defs><polygon points="@foreach ($monthlySales as $index => $month){{ $index * 180 }},{{ 90 - (($month['total'] / $monthlySalesMax) * 75) }} @endforeach 900,100 0,100" fill="url(#ownerDashboardGradient)" stroke="white" stroke-width="4" /></svg><div class="owner-chart-labels">@foreach ($monthlySales as $month)<span><strong>{{ $month['label'] }}</strong><small>Rp {{ number_format($month['total'], 0, ',', '.') }}</small></span>@endforeach</div></section>
<section class="owner-dashboard-panel"><h2>Transaksi Terbaru</h2><div class="owner-table-wrap"><table class="owner-table"><thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th></tr></thead><tbody>@forelse ($transactions as $transaction)<tr><td>{{ $transaction->transaction_code }}</td><td>{{ $transaction->customer?->name ?? 'Umum' }}</td><td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td><td>{{ $transaction->status ?: 'Menunggu Persetujuan' }}</td></tr>@empty<tr><td colspan="5">Belum ada transaksi.</td></tr>@endforelse</tbody></table></div></section>
@include('pemilik.partials.layout-end')
