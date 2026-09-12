@include('penjualan.partials.layout-start', ['title' => 'Laporan Penjualan'])
<style>
    .report-filter { display: flex; flex-wrap: wrap; align-items: end; gap: 12px; margin-bottom: 18px; }
    .report-filter label { display: grid; gap: 6px; color: #526166; font-size: 13px; }
    .report-filter input { padding: 9px; border: 1px solid #aab6ba; border-radius: 4px; font: inherit; }
    .report-summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-bottom: 18px; }
    .report-card { padding: 16px; border-radius: 7px; background: #126b7a; color: #fff; }
    .report-card strong { display: block; margin-bottom: 7px; font-size: 12px; font-weight: normal; }
    .report-card span { font-size: 21px; font-weight: bold; }
    @media (max-width: 600px) { .report-summary { grid-template-columns: 1fr; } .report-filter { align-items: stretch; flex-direction: column; } .report-filter label, .report-filter input, .report-filter .sales-button { width: 100%; } }
</style>
<h1>Laporan Penjualan</h1>
<form class="report-filter" method="GET" action="{{ route('penjualan.report') }}">
    <label>Dari tanggal<input type="date" name="from" value="{{ $from }}"></label>
    <label>Sampai tanggal<input type="date" name="to" value="{{ $to }}"></label>
    <button class="sales-button" type="submit">Tampilkan Laporan</button>
    <a class="sales-button" href="{{ route('penjualan.report') }}" style="background:#607177;">Reset</a>
</form>
<div class="report-summary">
    <div class="report-card"><strong>Total Transaksi</strong><span>{{ $transactionCount }}</span></div>
    <div class="report-card"><strong>Total Penjualan</strong><span>Rp {{ number_format($salesTotal, 0, ',', '.') }}</span></div>
    <div class="report-card"><strong>Pesanan Selesai</strong><span>{{ $completedCount }}</span></div>
</div>
<section class="sales-panel">
    <div class="sales-table-wrap">
        <table class="sales-table">
            <thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($transactions as $transaction)
                <tr><td>{{ $transaction->transaction_code }}</td><td>{{ $transaction->customer?->name ?? 'Umum' }}</td><td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td><td>{{ $transaction->payment_method }}</td><td>{{ $transaction->status ?: 'Menunggu Persetujuan' }}</td></tr>
            @empty
                <tr><td colspan="6">Tidak ada transaksi pada periode yang dipilih.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@include('penjualan.partials.layout-end')
