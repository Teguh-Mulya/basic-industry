@include('penjualan.partials.layout-start', ['title' => 'Melihat Produk'])
<h1>Melihat Produk</h1>
<section class="sales-panel"><div class="sales-table-wrap"><table class="sales-table"><thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Ukuran</th><th>Warna</th><th>Harga</th><th>Stok</th></tr></thead><tbody>
@forelse ($products as $product)
<tr><td>{{ $product->code }}</td><td>{{ $product->name }}</td><td>{{ $product->category?->name ?? '-' }}</td><td>{{ $product->size }}</td><td>{{ $product->color }}</td><td>Rp {{ number_format($product->price, 0, ',', '.') }}</td><td>{{ $product->stock?->quantity ?? 0 }}</td></tr>
@empty <tr><td colspan="7">Belum ada produk.</td></tr> @endforelse
</tbody></table></div></section>
@include('penjualan.partials.layout-end')
