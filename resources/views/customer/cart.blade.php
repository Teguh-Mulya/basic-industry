@include('customer.partials.layout-start', ['title' => 'Keranjang'])
<h1>Keranjang</h1>
@if (session('success')) <div class="message">{{ session('success') }}</div> @endif
<section class="panel"><div class="inner"><div class="table-scroll"><table>
<thead><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead>
<tbody>
@forelse ($products as $product)
<tr><td>{{ $product->name }}</td><td>Rp {{ number_format($product->price, 0, ',', '.') }}</td><td><form action="{{ route('customer.cart.update', $product) }}" method="POST">@csrf @method('PATCH')<input style="width:75px" type="number" name="quantity" value="{{ $cart[$product->id] }}" min="1"><button class="button" type="submit">Ubah</button></form></td><td>Rp {{ number_format($product->price * $cart[$product->id], 0, ',', '.') }}</td><td><form action="{{ route('customer.cart.remove', $product) }}" method="POST">@csrf @method('DELETE')<button class="button danger" type="submit">Hapus</button></form></td></tr>
@empty
<tr><td colspan="5">Keranjang masih kosong.</td></tr>
@endforelse
</tbody></table></div><h3 style="margin-top:15px">Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>@if ($products->isNotEmpty())<a class="button" href="{{ route('customer.checkout') }}">Lanjut Pemesanan</a>@endif</div></section>
@include('customer.partials.layout-end')
