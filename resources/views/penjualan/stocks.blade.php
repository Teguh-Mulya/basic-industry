@include('penjualan.partials.layout-start', ['title' => 'Melihat Stok'])
<h1>Melihat Stok</h1>
<section class="sales-panel"><div class="sales-table-wrap"><table class="sales-table"><thead><tr><th>Produk</th><th>Kode Produk</th><th>Jumlah Stok</th><th>Kondisi</th></tr></thead><tbody>
@forelse ($stocks as $stock)
<tr><td>{{ $stock->product?->name ?? '-' }}</td><td>{{ $stock->product?->code ?? '-' }}</td><td>{{ $stock->quantity }}</td><td>{{ $stock->quantity > 0 ? 'Tersedia' : 'Habis' }}</td></tr>
@empty <tr><td colspan="4">Belum ada data stok.</td></tr> @endforelse
</tbody></table></div></section>
@include('penjualan.partials.layout-end')
