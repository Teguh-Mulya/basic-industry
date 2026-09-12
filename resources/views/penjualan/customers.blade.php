@include('penjualan.partials.layout-start', ['title' => 'Mengelola Pelanggan'])
<h1>Mengelola Pelanggan</h1>
<div class="sales-toolbar"><form class="sales-search" method="GET"><input name="search" value="{{ $search }}" placeholder="Cari nama atau email"><button class="sales-button" type="submit">Cari</button></form></div>
<section class="sales-panel"><div class="sales-table-wrap"><table class="sales-table"><thead><tr><th>Nama</th><th>Email</th><th>Terdaftar</th><th>Pesanan</th></tr></thead><tbody>
@forelse ($customers as $customer)
<tr><td>{{ $customer->name }}</td><td>{{ $customer->email }}</td><td>{{ $customer->created_at?->format('d/m/Y') }}</td><td>{{ $customer->customerProfile?->transactions()->count() ?? 0 }}</td></tr>
@empty <tr><td colspan="4">Belum ada pelanggan.</td></tr> @endforelse
</tbody></table></div></section>
@include('penjualan.partials.layout-end')
