<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function landing(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $products = Product::with(['category', 'stock'])
            ->whereHas('stock', fn ($q) => $q->where('quantity', '>', 0))
            ->when($search !== '', fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('size', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($category) => $category->where('name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->get();

        return view('customer.dashboard', compact('products', 'search'));
    }

    public function dashboard(Request $request): View
    {
        return $this->landing($request);
    }

    public function products(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $products = Product::with(['category', 'stock'])->whereHas('stock', fn ($q) => $q->where('quantity', '>', 0))->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%"))->latest()->get();
        return view('customer.products.index', compact('products', 'search'));
    }

    public function showProduct(Product $product): View
    {
        return view('customer.products.show', compact('product'));
    }

    public function cart(): View
    {
        $cart = session('cart', []);
        $products = Product::with('stock')->whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn ($product) => $product->price * $cart[$product->id]);
        return view('customer.cart', compact('products', 'cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate(['product_id' => ['required', 'exists:products,id'], 'quantity' => ['required', 'integer', 'min:1']]);
        $product = Product::with('stock')->findOrFail($data['product_id']);
        $cart = session('cart', []);
        $quantity = ($cart[$product->id] ?? 0) + $data['quantity'];
        abort_if(! $product->stock || $quantity > $product->stock->quantity, 422, 'Jumlah melebihi stok tersedia.');
        $cart[$product->id] = $quantity;
        session(['cart' => $cart]);
        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        abort_if(! $product->stock || $data['quantity'] > $product->stock->quantity, 422, 'Jumlah melebihi stok tersedia.');
        $cart = session('cart', []); $cart[$product->id] = $data['quantity']; session(['cart' => $cart]);
        return back();
    }

    public function removeFromCart(Product $product)
    {
        $cart = session('cart', []); unset($cart[$product->id]); session(['cart' => $cart]); return back();
    }

    public function checkout(): View
    {
        $cart = session('cart', []); $products = Product::whereIn('id', array_keys($cart))->get();
        return view('customer.checkout', ['products' => $products, 'cart' => $cart, 'total' => $products->sum(fn ($p) => $p->price * $cart[$p->id]), 'paymentMethods' => PaymentMethod::where('is_active', true)->orderBy('name')->get()]);
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate(['payment_method' => ['required', Rule::exists('payment_methods', 'name')->where('is_active', true)]]);
        $cart = session('cart', []); abort_if(empty($cart), 422, 'Keranjang masih kosong.');
        DB::transaction(function () use ($data, $cart) {
            $profile = $this->profileModel();
            $transaction = Transaction::create(['transaction_code' => 'TRX-'.now()->format('YmdHis').'-'.random_int(100, 999), 'customer_id' => $profile->id, 'user_id' => auth()->id(), 'transaction_date' => now(), 'total_amount' => 0, 'payment_method' => $data['payment_method'], 'status' => 'Menunggu Persetujuan']);
            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::findOrFail($productId); $stock = Stock::where('product_id', $productId)->lockForUpdate()->first(); abort_if(! $stock || $stock->quantity < $quantity, 422, 'Stok produk tidak mencukupi.');
                $subtotal = $product->price * $quantity; $transaction->details()->create(['product_id' => $productId, 'quantity' => $quantity, 'price' => $product->price, 'subtotal' => $subtotal]); $stock->decrement('quantity', $quantity); $total += $subtotal;
            }
            $transaction->update(['total_amount' => $total]);
        });
        session()->forget('cart'); return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function orders(): View { return view('customer.orders.index', ['orders' => $this->customerOrders()]); }
    public function order(Transaction $transaction): View { abort_if($transaction->user_id !== auth()->id(), 403); return view('customer.orders.show', ['order' => $transaction->load('details.product', 'customer')]); }
    public function profile(): View { return view('customer.profile', ['profile' => $this->profileModel()]); }
    public function updateProfile(Request $request) { $data = $request->validate(['name' => ['required', 'max:100'], 'email' => ['required', 'email', 'unique:users,email,'.auth()->id()], 'phone' => ['nullable', 'max:20'], 'address' => ['nullable']]); auth()->user()->update(['name' => $data['name'], 'email' => $data['email']]); $this->profileModel()->update(['name' => $data['name'], 'phone' => $data['phone'] ?? null, 'address' => $data['address'] ?? null]); return back()->with('success', 'Profil berhasil diperbarui.'); }
    private function profileModel(): Customer { return Customer::firstOrCreate(['user_id' => auth()->id()], ['name' => auth()->user()->name]); }
    private function customerOrders() { return Transaction::with('details.product')->where('user_id', auth()->id())->latest('transaction_date')->get(); }
}