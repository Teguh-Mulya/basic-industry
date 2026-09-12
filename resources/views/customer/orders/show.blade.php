@include('customer.partials.layout-start', ['title' => 'Detail Pesanan'])
@php($status = $order->status ?: 'Menunggu Persetujuan')
@php($statusStep = ['Menunggu Persetujuan' => 1, 'Diproses' => 2, 'Dikirim' => 3, 'Selesai' => 4][$status] ?? 1)
<style>
	.tracking-detail { margin: 18px 0; padding: 15px; border: 1px solid #d4dadd; border-radius: 6px; background: #f7f9fa; }
	.tracking-detail strong { color: #126b7a; }
	.tracking-line { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 14px; }
	.tracking-line span { height: 8px; border-radius: 5px; background: #d4dadd; }
	.tracking-line .active { background: #126b7a; }
</style>
<h1>Detail Pesanan {{ $order->transaction_code }}</h1><section class="panel"><div class="inner"><p>Tanggal: {{ $order->transaction_date?->format('d/m/Y H:i') }}</p><div class="tracking-detail"><strong>Status: {{ $status }}</strong><p>{{ $status === 'Menunggu Persetujuan' ? 'Pesanan Anda menunggu persetujuan admin penjualan.' : ($status === 'Diproses' ? 'Pesanan Anda sedang diproses oleh admin penjualan.' : ($status === 'Dikirim' ? 'Pesanan sudah dikirim menuju alamat Anda.' : 'Pesanan telah selesai.')) }}</p><div class="tracking-line" aria-label="Tahap {{ $status }}"><span class="active"></span><span class="{{ $statusStep >= 2 ? 'active' : '' }}"></span><span class="{{ $statusStep >= 3 ? 'active' : '' }}"></span><span class="{{ $statusStep >= 4 ? 'active' : '' }}"></span></div></div><table><thead><tr><th>Produk</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>@foreach($order->details as $detail)<tr><td>{{ $detail->product?->name ?? '-' }}</td><td>{{ $detail->quantity }}</td><td>Rp {{ number_format($detail->price,0,',','.') }}</td><td>Rp {{ number_format($detail->subtotal,0,',','.') }}</td></tr>@endforeach</tbody></table><h3>Total: Rp {{ number_format($order->total_amount,0,',','.') }}</h3></div></section>
@include('customer.partials.layout-end')
