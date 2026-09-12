@include('pemilik.partials.layout-start', ['title' => 'Laporan Penjualan'])
<style>
    .owner-report-filter { display: flex; flex-wrap: wrap; align-items: end; gap: 12px; margin-bottom: 18px; }
    .owner-report-filter label { display: grid; gap: 6px; color: #526166; font-size: 13px; }
    .owner-report-filter input { padding: 9px; border: 1px solid #aab6ba; border-radius: 4px; font: inherit; }
    .owner-report-summary { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-bottom: 18px; }
    .owner-report-card { padding: 16px; border-radius: 7px; background: #126b7a; color: #fff; }
    .owner-report-card strong { display: block; margin-bottom: 7px; font-size: 12px; font-weight: normal; }
    .owner-report-card span { font-size: 21px; font-weight: bold; }
    @media (max-width: 600px) { .owner-report-summary { grid-template-columns: 1fr; } .owner-report-filter { align-items: stretch; flex-direction: column; } .owner-report-filter label, .owner-report-filter input, .owner-report-filter .owner-button { width: 100%; } }
</style>
<h1>Laporan Penjualan</h1>
<form class="owner-report-filter" method="GET" action="{{ route('pemilik.report') }}"><label>Dari tanggal<input type="date" name="from" value="{{ $from }}"></label><label>Sampai tanggal<input type="date" name="to" value="{{ $to }}"></label><button class="owner-button" type="submit">Tampilkan Laporan</button><a class="owner-button" href="{{ route('pemilik.report') }}" style="background:#607177;">Reset</a><a class="owner-button" href="{{ route('pemilik.report.print', ['from' => $from, 'to' => $to]) }}" target="_blank">Cetak</a></form>
<div class="owner-report-summary"><div class="owner-report-card"><strong>Total Transaksi</strong><span>{{ $transactionCount }}</span></div><div class="owner-report-card"><strong>Total Penjualan</strong><span>Rp {{ number_format($salesTotal, 0, ',', '.') }}</span></div></div>
<section class="owner-panel"><div class="owner-table-wrap"><table class="owner-table"><thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Status</th></tr></thead><tbody>@forelse ($transactions as $transaction)<tr><td>{{ $transaction->transaction_code }}</td><td>{{ $transaction->customer?->name ?? 'Umum' }}</td><td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td><td>{{ $transaction->payment_method }}</td><td>{{ $transaction->status ?: 'Menunggu Persetujuan' }}</td></tr>@empty<tr><td colspan="6">Tidak ada transaksi pada periode yang dipilih.</td></tr>@endforelse</tbody></table></div></section>
@include('pemilik.partials.layout-end')
