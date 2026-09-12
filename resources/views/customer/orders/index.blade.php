@include('customer.partials.layout-start', ['title' => 'Pesanan Saya'])
<h1>Pesanan Saya dan Riwayat Pesanan</h1>
@if (session('success')) <div class="message">{{ session('success') }}</div> @endif
<section class="panel"><div class="inner"><div class="table-scroll"><table>
<thead><tr><th>Kode</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Detail</th></tr></thead>
<tbody>
@forelse ($orders as $order)
<tr><td>{{ $order->transaction_code }}</td><td>{{ $order->transaction_date?->format('d/m/Y H:i') }}</td><td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td><td>{{ $order->payment_method }}</td><td><a class="button" href="{{ route('customer.orders.show', $order) }}">Lihat</a></td></tr>
@empty
<tr><td colspan="5">Belum ada pesanan.</td></tr>
@endforelse
</tbody></table></div></div></section>
@include('customer.partials.layout-end')
