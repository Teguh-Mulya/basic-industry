@include('customer.partials.layout-start', ['title' => 'Dashboard Customer'])
<h1>Dashboard</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>
<form class="toolbar" method="GET" action="{{ route('customer.dashboard') }}" style="margin:18px 0 16px">
    <input name="search" value="{{ $search ?? '' }}" placeholder="Cari Produk">
    <button class="search-button" type="submit">Cari</button>
</form>
<section class="stack">
    <h2>Produk Terbaru</h2>
    <div class="product-grid">
        @forelse ($products as $product)
            <article class="product-card">
                <div class="product-card-image">
                    @if ($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                        Foto produk
                    @endif
                    <div class="product-card-caption">
                        <div class="product-card-name">{{ $product->name }}</div>
                        <div class="product-card-meta">Rp {{ number_format($product->price, 0, ',', '.') }} / Stok {{ $product->stock?->quantity ?? 0 }}</div>
                    </div>
                </div>
                <div class="product-card-body">
                    <div class="product-card-actions">
                        <form action="{{ route('customer.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button class="button" type="submit">Keranjang</button>
                        </form>
                        <a class="button" href="{{ route('customer.products.show', $product) }}">Beli</a>
                    </div>
                </div>
            </article>
        @empty
            <p>Belum ada produk tersedia.</p>
        @endforelse
    </div>
</section>
@include('customer.partials.layout-end')
