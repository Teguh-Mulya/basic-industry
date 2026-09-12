@include('penjualan.partials.layout-start', ['title' => 'Mengelola Pesanan'])
<h1>Mengelola Pesanan</h1>
<section class="sales-panel"><div class="sales-table-wrap"><table class="sales-table"><thead><tr><th>Kode</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status Saat Ini</th><th>Ubah Status</th></tr></thead><tbody>
@forelse ($transactions as $transaction)
@php($currentStatus = $transaction->status ?: 'Menunggu Persetujuan')
<tr><td>{{ $transaction->transaction_code }}</td><td>{{ $transaction->customer?->name ?? 'Umum' }}</td><td>{{ $transaction->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td><td>{{ $currentStatus }}</td><td><form class="status-form" action="{{ route('penjualan.orders.status', $transaction) }}" method="POST">@csrf @method('PATCH')<select name="status" aria-label="Status {{ $transaction->transaction_code }}">@foreach (['Menunggu Persetujuan', 'Diproses', 'Dikirim', 'Selesai'] as $status)<option value="{{ $status }}" @selected($currentStatus === $status)>{{ $status }}</option>@endforeach</select><button type="submit">Simpan</button></form></td></tr>
@empty <tr><td colspan="6">Belum ada pesanan aktif.</td></tr> @endforelse
</tbody></table></div></section>
@include('penjualan.partials.layout-end')
