@include('customer.partials.layout-start', ['title' => 'Produk'])
<h1>Melihat Produk</h1>
<form class="toolbar" method="GET" action="{{ route('customer.products.index') }}" style="margin-bottom:16px">
    <input style="max-width:320px" name="search" value="{{ $search }}" placeholder="Cari produk">
</form>
<section class="panel"><div class="inner"><div class="table-scroll"><table>
<thead><tr><th>Produk</th><th>Kategori</th><th>Ukuran</th><th>Warna</th><th>Harga</th><th>Aksi</th></tr></thead>
<tbody>
@forelse ($products as $product)
<tr><td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '-' }}</td><td>{{ $product->size }}</td><td>{{ $product->color }}</td><td>Rp {{ number_format($product->price, 0, ',', '.') }}</td><td><a class="button" href="{{ route('customer.products.show', $product) }}">Detail</a></td></tr>
@empty
<tr><td colspan="6">Belum ada produk tersedia.</td></tr>
@endforelse
</tbody></table></div></div></section>
@include('customer.partials.layout-end')
