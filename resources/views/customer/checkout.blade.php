@include('customer.partials.layout-start', ['title' => 'Pemesanan'])
<style>
    .checkout-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(280px, 360px); gap: 18px; align-items: start; }
    .payment-options { display: grid; gap: 10px; }
    .payment-option { display: block; padding: 13px; border: 1px solid #ccd6d8; border-radius: 6px; cursor: pointer; }
    .payment-option:has(input:checked) { border-color: #126b7a; background: #eef8f9; box-shadow: 0 0 0 2px rgba(18,107,122,.12); }
    .payment-option input { width: auto; margin-right: 8px; accent-color: #126b7a; }
    .payment-name { font-weight: bold; }
    .payment-detail { margin-top: 6px; color: #526166; font-size: 13px; line-height: 1.5; }
    .payment-detail strong { color: #263238; }
    .payment-detail-box { display: none; margin-top: 15px; padding: 15px; border-radius: 6px; background: #f4f8f8; color: #263238; }
    .payment-detail-box.active { display: block; }
    #qris-code { margin: 12px auto 0; width: 180px; padding: 8px; background: #fff; text-align: center; }
    .checkout-total { font-size: 22px; font-weight: bold; color: #126b7a; }
    @media (max-width: 700px) { .checkout-grid { grid-template-columns: 1fr; } .checkout-total { font-size: 20px; } }
</style>

<h1>Melakukan Pemesanan</h1>

@if ($errors->any())
    <div class="message" style="background:#ffe4e4;color:#8b0000;">{{ $errors->first() }}</div>
@endif

<div class="checkout-grid">
    <section class="panel">
        <div class="inner">
            <h2>Metode Pembayaran</h2>
            <p style="margin-bottom:14px;color:#526166;">Pilih metode pembayaran untuk melihat instruksi lengkapnya.</p>
            <form id="checkout-form" action="{{ route('customer.orders.store') }}" method="POST">
                @csrf
                <div class="payment-options">
                    @forelse ($paymentMethods as $method)
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="{{ $method->name }}" data-method="{{ $method->id }}" @checked($loop->first) required>
                            <span class="payment-name">{{ $method->name }}</span>
                            <div class="payment-detail">{{ $method->description ?: 'Informasi pembayaran tersedia di bawah.' }}</div>
                        </label>
                    @empty
                        <p>Belum ada metode pembayaran aktif.</p>
                    @endforelse
                </div>

                @foreach ($paymentMethods as $method)
                    <div class="payment-detail-box" data-detail="{{ $method->id }}">
                        <strong>{{ $method->name }}</strong>
                        @if ($method->description)<p>{{ $method->description }}</p>@endif
                        @if ($method->account_number)<p><strong>{{ $method->name === 'Transfer Bank' ? 'Nomor Rekening' : 'Nomor / ID Pembayaran' }}:</strong><br>{{ $method->account_number }}</p>@endif
                        @if ($method->account_name)<p><strong>Atas Nama:</strong><br>{{ $method->account_name }}</p>@endif
                        @if ($method->details)<p><strong>Instruksi:</strong><br>{!! nl2br(e($method->details)) !!}</p>@endif
                        @if ($method->name === 'QRIS' && $method->account_number)
                            <div id="qris-code" data-payload="{{ $method->account_number }}"></div>
                            <p style="text-align:center;font-size:12px;">Scan QRIS ini menggunakan aplikasi pembayaran Anda.</p>
                        @endif
                    </div>
                @endforeach
            </form>
        </div>
    </section>

    <aside class="panel">
        <div class="inner">
            <h2>Ringkasan Pesanan</h2>
            @foreach ($products as $product)
                <p style="display:flex;justify-content:space-between;gap:10px;margin:10px 0;"><span>{{ $product->name }} x{{ $cart[$product->id] }}</span><strong>Rp {{ number_format($product->price * $cart[$product->id], 0, ',', '.') }}</strong></p>
            @endforeach
            <hr>
            <p>Total Pembayaran</p>
            <p class="checkout-total">Rp {{ number_format($total, 0, ',', '.') }}</p>
            <button class="button" style="width:100%;margin-top:10px;" type="submit" form="checkout-form" @disabled($paymentMethods->isEmpty())>Konfirmasi Pesanan</button>
        </div>
    </aside>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const paymentInputs = document.querySelectorAll('input[name="payment_method"]');
    const detailBoxes = document.querySelectorAll('[data-detail]');
    const qrisElement = document.getElementById('qris-code');

    function showPaymentDetails() {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        detailBoxes.forEach((box) => box.classList.toggle('active', selected && box.dataset.detail === selected.dataset.method));
    }

    paymentInputs.forEach((input) => input.addEventListener('change', showPaymentDetails));
    showPaymentDetails();
    if (qrisElement && typeof QRCode !== 'undefined') {
        new QRCode(qrisElement, { text: qrisElement.dataset.payload, width: 160, height: 160 });
    }
</script>
@include('customer.partials.layout-end')
