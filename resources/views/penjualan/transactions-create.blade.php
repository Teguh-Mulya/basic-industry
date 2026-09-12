@include('penjualan.partials.layout-start', ['title' => 'Membuat Transaksi Penjualan'])
<h1>Membuat Transaksi Penjualan</h1>
<section class="sales-panel"><form class="sales-form" action="{{ route('penjualan.transactions.store') }}" method="POST">
@csrf
<label>Pelanggan<select name="customer_id" required><option value="">Pilih pelanggan</option>@foreach ($customers as $customer)<option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}{{ $customer->phone ? ' - '.$customer->phone : '' }}</option>@endforeach</select></label>
<label>Total Transaksi<input type="number" name="total_amount" min="0" step="0.01" value="{{ old('total_amount') }}" required></label>
<label>Metode Pembayaran<select name="payment_method" required><option value="">Pilih metode pembayaran</option>@foreach ($paymentMethods as $paymentMethod)<option value="{{ $paymentMethod->name }}" @selected(old('payment_method') === $paymentMethod->name)>{{ $paymentMethod->name }}</option>@endforeach</select></label>
<label>Tanggal Transaksi<input type="datetime-local" name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}" required></label>
<div><button class="sales-button" type="submit">Simpan Transaksi</button></div>
</form></section>
@include('penjualan.partials.layout-end')
