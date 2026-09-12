@include('customer.partials.layout-start', ['title' => 'Pesanan Saya'])
<style>
	.order-status { color: #126b7a; font-weight: bold; white-space: nowrap; }
	.tracking { min-width: 240px; }
	.tracking-steps { display: flex; gap: 5px; margin-top: 7px; }
	.tracking-step { flex: 1; height: 6px; border-radius: 5px; background: #d4dadd; }
	.tracking-step.active { background: #126b7a; }
</style>
<h1>Pesanan Saya dan Riwayat Pesanan</h1>
@if (session('success')) <div class="message">{{ session('success') }}</div> @endif
<section class="panel"><div class="inner"><div class="table-scroll"><table>
<thead><tr><th>Kode</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Status Pesanan</th><th>Tracking</th><th>Detail</th></tr></thead>
<tbody>
@forelse ($orders as $order)
@php($status = $order->status ?: 'Menunggu Persetujuan')
@php($statusStep = ['Menunggu Persetujuan' => 1, 'Diproses' => 2, 'Dikirim' => 3, 'Selesai' => 4][$status] ?? 1)
<tr><td>{{ $order->transaction_code }}</td><td>{{ $order->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td><td>{{ $order->payment_method }}</td><td class="order-status">{{ $status }}</td><td class="tracking"><span>{{ $status === 'Menunggu Persetujuan' ? 'Menunggu persetujuan admin' : ($status === 'Diproses' ? 'Pesanan sedang diproses' : ($status === 'Dikirim' ? 'Pesanan menuju alamat Anda' : 'Pesanan selesai')) }}</span><div class="tracking-steps" aria-label="Tahap {{ $status }}"><span class="tracking-step active"></span><span class="tracking-step {{ $statusStep >= 2 ? 'active' : '' }}"></span><span class="tracking-step {{ $statusStep >= 3 ? 'active' : '' }}"></span><span class="tracking-step {{ $statusStep >= 4 ? 'active' : '' }}"></span></div></td><td><a class="button" href="{{ route('customer.orders.show', $order) }}">Lihat</a></td></tr>
@empty
<tr><td colspan="7">Belum ada pesanan.</td></tr>
@endforelse
</tbody></table></div></div></section>
@include('customer.partials.layout-end')
