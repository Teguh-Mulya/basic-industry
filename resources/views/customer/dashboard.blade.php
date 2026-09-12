@include('customer.partials.layout-start', ['title' => 'Beranda Customer'])
<style>
    .customer-landing { display: grid; gap: 26px; }
    .customer-hero { position: relative; overflow: hidden; min-height: 300px; padding: clamp(26px, 5vw, 52px); border-radius: 12px; background: #126b7a; color: #fff; box-shadow: 0 12px 28px rgba(18,107,122,.2); }
    .customer-kicker { margin: 0 0 12px; color: #bfe9ee; font-size: 12px; font-weight: bold; letter-spacing: .08em; text-transform: uppercase; }
    .customer-hero h1 { max-width: 620px; margin: 0 0 14px; color: #fff; font-size: clamp(30px, 5vw, 52px); line-height: 1.05; }
    .customer-hero p { max-width: 520px; margin: 0 0 24px; color: #e4f8fa; font-size: 15px; line-height: 1.6; }
    .customer-actions { display: flex; flex-wrap: wrap; gap: 10px; }
    .customer-actions .button { min-width: 145px; background: #fff; color: #126b7a; font-weight: bold; }
    .customer-actions .button:hover { background: #e4f8fa; }
    .customer-section-head { display: flex; align-items: end; justify-content: space-between; gap: 14px; }
    .customer-section-head h2 { margin: 0; font-size: 22px; }
    .customer-section-head p { margin: 0; color: #607177; font-size: 13px; }
    .customer-search { display: flex; gap: 10px; }
    .customer-search input { flex: 1; width: auto; }
    .customer-search .search-button { white-space: nowrap; }
    @media (max-width: 600px) { .customer-hero { min-height: 270px; } .customer-section-head { align-items: stretch; flex-direction: column; } .customer-search { flex-direction: column; } .customer-search .search-button { width: 100%; } .customer-actions { flex-direction: column; } .customer-actions .button { width: 100%; } }
</style>
<div class="customer-landing">
    <section class="customer-hero">
        <p class="customer-kicker">Basic Industry Collection</p>
        <h1>Temukan produk yang siap melengkapi kebutuhan Anda.</h1>
        <p>Selamat datang{{ auth()->check() ? ', '.auth()->user()->name : '' }}. Jelajahi koleksi terbaru, pilih produk favorit, dan pantau pesanan Anda dalam satu tempat.</p>
        <div class="customer-actions">
            <a class="button" href="{{ auth()->check() ? route('customer.products.index') : route('customer.login') }}">{{ auth()->check() ? 'Lihat Semua Produk' : 'Masuk untuk Belanja' }}</a>
            <a class="button" href="{{ auth()->check() ? route('customer.orders.index') : route('customer.register') }}">{{ auth()->check() ? 'Lacak Pesanan' : 'Daftar Customer' }}</a>
        </div>
    </section>
    <section class="stack">
        <div class="customer-section-head">
            <div><h2>Produk Pilihan</h2><p>Koleksi terbaru yang tersedia untuk Anda.</p></div>
            <form class="customer-search" method="GET" action="{{ auth()->check() ? route('customer.dashboard') : route('home') }}">
                <input name="search" value="{{ $search ?? '' }}" placeholder="Cari produk" aria-label="Cari produk">
                <button class="search-button" type="submit">Cari</button>
            </form>
        </div>
        <div class="product-grid">
            @forelse ($products as $product)
                <article class="product-card">
                    <div class="product-card-image">
                        @if ($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        @else
                            Foto produk
                        @endif
                        <div class="product-card-caption"><div class="product-card-name">{{ $product->name }}</div><div class="product-card-meta">Rp {{ number_format($product->price, 0, ',', '.') }} / Stok {{ $product->stock?->quantity ?? 0 }}</div></div>
                    </div>
                    <div class="product-card-body"><div class="product-card-actions">@if (auth()->check())<form action="{{ route('customer.cart.add') }}" method="POST">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><input type="hidden" name="quantity" value="1"><button class="button" type="submit">Keranjang</button></form><a class="button" href="{{ route('customer.products.show', $product) }}">Beli</a>@else<a class="button" href="{{ route('customer.login') }}">Masuk untuk Beli</a>@endif</div></div>
                </article>
            @empty
                <p>Belum ada produk tersedia.</p>
            @endforelse
        </div>
    </section>
</div>
@include('customer.partials.layout-end')
