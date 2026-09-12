@include('customer.partials.layout-start', ['title' => 'Detail Produk'])

<h1>Detail Produk</h1>
<section class="panel">
    <div class="inner">
        @if ($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="display:block;width:min(100%,420px);height:280px;object-fit:cover;margin-bottom:16px;border-radius:6px;">
        @endif
        <h2>{{ $product->name }}</h2>
        <p>{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
        <p>Kategori: {{ $product->category?->name ?? '-' }} | Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p>Stok tersedia: {{ $product->stock?->quantity ?? 0 }}</p>
        <form action="{{ route('customer.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <label>Ukuran <select name="size" required><option value="{{ $product->size }}">{{ $product->size }}</option></select></label><br>
            <label>Warna <select name="color" required><option value="{{ $product->color }}">{{ $product->color }}</option></select></label><br>
            <label>Jumlah <input type="number" name="quantity" min="1" max="{{ $product->stock?->quantity ?? 0 }}" value="1" required></label><br>
            <button class="button" type="submit">Tambah ke Keranjang</button>
        </form>
    </div>
</section>

@include('customer.partials.layout-end')
