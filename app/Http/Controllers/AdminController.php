<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $startMonth = now()->startOfMonth()->subMonths(5);
        $monthlySales = collect(range(0, 5))->map(function (int $offset) use ($startMonth) {
            $month = $startMonth->copy()->addMonths($offset);

            return [
                'label' => $month->translatedFormat('M Y'),
                'total' => (float) Transaction::whereBetween('transaction_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->sum('total_amount'),
            ];
        });

        return view('admin.dashboard', ['productCount' => Product::count(), 'orderCount' => Transaction::count(), 'customerCount' => Customer::count(), 'salesTotal' => Transaction::sum('total_amount'), 'recentTransactions' => Transaction::with('customer')->latest('transaction_date')->limit(5)->get(), 'monthlySales' => $monthlySales, 'monthlySalesMax' => max(1, $monthlySales->max('total'))]);
    }

    public function products(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $records = Product::with(['category', 'stock'])->when($search !== '', fn ($query) => $query->where(fn ($q) => $q->where('code', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%")->orWhere('size', 'like', "%{$search}%")->orWhere('color', 'like', "%{$search}%")->orWhereHas('category', fn ($category) => $category->where('name', 'like', "%{$search}%"))))->latest()->get();
        return $this->resource('Produk', $records, ['Kode' => 'code', 'Nama' => 'name', 'Kategori' => fn (Product $p) => $p->category?->name ?? '-', 'Harga' => fn (Product $p) => 'Rp '.number_format($p->price, 0, ',', '.'), 'Stok' => fn (Product $p) => $p->stock?->quantity ?? 0], 'admin.products.index');
    }

    public function createProduct(): View { return $this->form('Tambah Produk', 'admin.products.store', $this->productFields()); }
    public function storeProduct(Request $request) { $data = $request->validate($this->productRules()); if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('products', 'public'); Product::create($data); return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.'); }
    public function editProduct(Product $product): View { return $this->form('Edit Produk', 'admin.products.update', $this->productFields(), $product, ['product' => $product]); }
    public function updateProduct(Request $request, Product $product) { $data = $request->validate($this->productRules($product)); if ($request->hasFile('image')) { if ($product->image) Storage::disk('public')->delete($product->image); $data['image'] = $request->file('image')->store('products', 'public'); } $product->update($data); return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.'); }
    public function destroyProduct(Product $product) { if ($product->image) Storage::disk('public')->delete($product->image); $product->delete(); return back()->with('success', 'Produk berhasil dihapus.'); }

    public function categories(): View { return $this->resource('Kategori', Category::withCount('products')->latest()->get(), ['Nama' => 'name', 'Deskripsi' => fn (Category $c) => $c->description ?: '-', 'Jumlah Produk' => 'products_count'], 'admin.categories.index'); }
    public function createCategory(): View { return $this->form('Tambah Kategori', 'admin.categories.store', [['name' => 'name', 'label' => 'Nama Kategori', 'type' => 'text', 'required' => true], ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea']]); }
    public function storeCategory(Request $request) { Category::create($request->validate(['name' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string']])); return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.'); }
    public function editCategory(Category $category): View { return $this->form('Edit Kategori', 'admin.categories.update', [['name' => 'name', 'label' => 'Nama Kategori', 'type' => 'text', 'required' => true], ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea']], $category, ['category' => $category]); }
    public function updateCategory(Request $request, Category $category) { $category->update($request->validate(['name' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string']])); return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.'); }
    public function destroyCategory(Category $category) { $category->delete(); return back()->with('success', 'Kategori berhasil dihapus.'); }

    public function stocks(): View { return $this->resource('Stok', Stock::with('product')->latest()->get(), ['Produk' => fn (Stock $s) => $s->product?->name ?? '-', 'Kode Produk' => fn (Stock $s) => $s->product?->code ?? '-', 'Jumlah' => 'quantity'], 'admin.stocks.index'); }
    public function createStock(): View { return $this->form('Tambah Stok', 'admin.stocks.store', [['name' => 'product_id', 'label' => 'Produk', 'type' => 'select', 'options' => Product::orderBy('name')->pluck('name', 'id')->all(), 'required' => true], ['name' => 'quantity', 'label' => 'Jumlah Stok', 'type' => 'number', 'required' => true]]); }
    public function storeStock(Request $request) { Stock::create($request->validate(['product_id' => ['required', 'exists:products,id', 'unique:stocks,product_id'], 'quantity' => ['required', 'integer', 'min:0']])); return redirect()->route('admin.stocks.index')->with('success', 'Stok berhasil ditambahkan.'); }
    public function editStock(Stock $stock): View { return $this->form('Edit Stok', 'admin.stocks.update', [['name' => 'product_id', 'label' => 'Produk', 'type' => 'select', 'options' => Product::orderBy('name')->pluck('name', 'id')->all(), 'required' => true], ['name' => 'quantity', 'label' => 'Jumlah Stok', 'type' => 'number', 'required' => true]], $stock, ['stock' => $stock]); }
    public function updateStock(Request $request, Stock $stock) { $stock->update($request->validate(['product_id' => ['required', 'exists:products,id', 'unique:stocks,product_id,'.$stock->id], 'quantity' => ['required', 'integer', 'min:0']])); return redirect()->route('admin.stocks.index')->with('success', 'Stok berhasil diperbarui.'); }
    public function destroyStock(Stock $stock) { $stock->delete(); return back()->with('success', 'Stok berhasil dihapus.'); }

    public function customers(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $customers = User::query()
            ->where('role', 'customer')
            ->when($search !== '', fn ($query) => $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->latest()
            ->get();

        return view('admin.customers.index', compact('customers', 'search'));
    }
    public function createCustomer(): View { return $this->form('Tambah Pelanggan', 'admin.customers.store', [['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true], ['name' => 'phone', 'label' => 'Telepon', 'type' => 'text'], ['name' => 'address', 'label' => 'Alamat', 'type' => 'textarea']]); }
    public function storeCustomer(Request $request) { Customer::create($request->validate(['name' => ['required', 'string', 'max:100'], 'phone' => ['nullable', 'string', 'max:20'], 'address' => ['nullable', 'string']])); return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil ditambahkan.'); }
    public function editCustomer(Customer $customer): View { return $this->form('Edit Pelanggan', 'admin.customers.update', [['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true], ['name' => 'phone', 'label' => 'Telepon', 'type' => 'text'], ['name' => 'address', 'label' => 'Alamat', 'type' => 'textarea']], $customer, ['customer' => $customer]); }
    public function updateCustomer(Request $request, Customer $customer) { $customer->update($request->validate(['name' => ['required', 'string', 'max:100'], 'phone' => ['nullable', 'string', 'max:20'], 'address' => ['nullable', 'string']])); return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil diperbarui.'); }
    public function destroyCustomer(Customer $customer) { $customer->delete(); return back()->with('success', 'Pelanggan berhasil dihapus.'); }

    public function transactions(): View { return $this->resource('Transaksi', Transaction::with(['customer', 'user', 'details'])->latest('transaction_date')->get(), ['Kode' => 'transaction_code', 'Pelanggan' => fn (Transaction $t) => $t->customer?->name ?? 'Umum', 'Tanggal' => fn (Transaction $t) => $t->transaction_date?->format('d/m/Y H:i'), 'Total' => fn (Transaction $t) => 'Rp '.number_format($t->total_amount, 0, ',', '.'), 'Pembayaran' => 'payment_method'], 'admin.transactions.index'); }
    public function createTransaction(): View { return $this->form('Tambah Transaksi', 'admin.transactions.store', [['name' => 'transaction_code', 'label' => 'Kode Transaksi', 'type' => 'text', 'required' => true], ['name' => 'customer_id', 'label' => 'Pelanggan', 'type' => 'select', 'options' => ['' => 'Umum'] + Customer::pluck('name', 'id')->all()], ['name' => 'transaction_date', 'label' => 'Tanggal Transaksi', 'type' => 'datetime-local', 'required' => true], ['name' => 'total_amount', 'label' => 'Total', 'type' => 'number', 'required' => true], ['name' => 'payment_method', 'label' => 'Metode Pembayaran', 'type' => 'text', 'required' => true]]); }
    public function storeTransaction(Request $request) { $data = $request->validate(['transaction_code' => ['required', 'max:50', 'unique:transactions,transaction_code'], 'customer_id' => ['nullable', 'exists:customers,id'], 'transaction_date' => ['required', 'date'], 'total_amount' => ['required', 'numeric', 'min:0'], 'payment_method' => ['required', 'max:30']]); $data['user_id'] = auth()->id(); Transaction::create($data); return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil ditambahkan.'); }
    public function editTransaction(Transaction $transaction): View { return $this->form('Edit Transaksi', 'admin.transactions.update', [['name' => 'transaction_code', 'label' => 'Kode Transaksi', 'type' => 'text', 'required' => true], ['name' => 'customer_id', 'label' => 'Pelanggan', 'type' => 'select', 'options' => ['' => 'Umum'] + Customer::pluck('name', 'id')->all()], ['name' => 'transaction_date', 'label' => 'Tanggal Transaksi', 'type' => 'datetime-local', 'required' => true], ['name' => 'total_amount', 'label' => 'Total', 'type' => 'number', 'required' => true], ['name' => 'payment_method', 'label' => 'Metode Pembayaran', 'type' => 'text', 'required' => true]], $transaction, ['transaction' => $transaction]); }
    public function updateTransaction(Request $request, Transaction $transaction) { $transaction->update($request->validate(['transaction_code' => ['required', 'max:50', 'unique:transactions,transaction_code,'.$transaction->id], 'customer_id' => ['nullable', 'exists:customers,id'], 'transaction_date' => ['required', 'date'], 'total_amount' => ['required', 'numeric', 'min:0'], 'payment_method' => ['required', 'max:30']])); return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui.'); }
    public function destroyTransaction(Transaction $transaction) { $transaction->delete(); return back()->with('success', 'Transaksi berhasil dihapus.'); }

    public function reports(): View { return view('admin.reports.index', ['transactions' => Transaction::with('customer')->latest('transaction_date')->get(), 'salesTotal' => Transaction::sum('total_amount')]); }
    public function printReport(): View { return view('admin.reports.print', ['transactions' => Transaction::with('customer')->latest('transaction_date')->get(), 'salesTotal' => Transaction::sum('total_amount')]); }
    public function users(): View { return $this->resource('Pengguna dan Hak Akses', User::latest()->get(), ['Nama' => 'name', 'Email' => 'email', 'Role' => 'role'], 'admin.users.index'); }
    public function createUser(): View { return $this->form('Tambah Pengguna', 'admin.users.store', [['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true], ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true], ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'required' => true], ['name' => 'role', 'label' => 'Hak Akses', 'type' => 'select', 'options' => ['admin' => 'Admin', 'pemilik' => 'Pemilik', 'admin_penjualan' => 'Admin Penjualan', 'customer' => 'Customer'], 'required' => true]]); }
    public function storeUser(Request $request) { $data = $request->validate(['name' => ['required'], 'email' => ['required', 'email', 'unique:users,email'], 'password' => ['required', 'min:8'], 'role' => ['required', 'in:admin,pemilik,admin_penjualan,customer']]); $data['password'] = Hash::make($data['password']); User::create($data); return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.'); }
    public function editUser(User $user): View { return $this->form('Edit Pengguna', 'admin.users.update', [['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true], ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true], ['name' => 'password', 'label' => 'Password Baru', 'type' => 'password'], ['name' => 'role', 'label' => 'Hak Akses', 'type' => 'select', 'options' => ['admin' => 'Admin', 'pemilik' => 'Pemilik', 'admin_penjualan' => 'Admin Penjualan', 'customer' => 'Customer'], 'required' => true]], $user, ['user' => $user]); }
    public function updateUser(Request $request, User $user) { $data = $request->validate(['name' => ['required'], 'email' => ['required', 'email', 'unique:users,email,'.$user->id], 'role' => ['required', 'in:admin,pemilik,admin_penjualan,customer']]); $user->update($data); return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.'); }
    public function destroyUser(User $user) { abort_if($user->is(auth()->user()), 422); $user->delete(); return back(); }

    private function productFields(): array { return [['name' => 'category_id', 'label' => 'Kategori', 'type' => 'select', 'options' => Category::pluck('name', 'id')->all(), 'required' => true], ['name' => 'code', 'label' => 'Kode Produk', 'type' => 'text', 'required' => true], ['name' => 'name', 'label' => 'Nama Produk', 'type' => 'text', 'required' => true], ['name' => 'size', 'label' => 'Ukuran', 'type' => 'text', 'required' => true], ['name' => 'color', 'label' => 'Warna', 'type' => 'text', 'required' => true], ['name' => 'price', 'label' => 'Harga', 'type' => 'number', 'required' => true], ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'], ['name' => 'image', 'label' => 'Gambar Produk', 'type' => 'file']]; }
    private function productRules(?Product $product = null): array { return ['category_id' => ['required', 'exists:categories,id'], 'code' => ['required', 'max:50', 'unique:products,code'.($product ? ','.$product->id : '')], 'name' => ['required', 'max:150'], 'size' => ['required', 'max:20'], 'color' => ['required', 'max:50'], 'price' => ['required', 'numeric', 'min:0'], 'description' => ['nullable'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']]; }
    private function resource(string $title, $records, array $columns, string $view): View { $resource = str_replace(['admin.', '.index'], '', $view); return view($view, compact('title', 'records', 'columns', 'resource')); }
    private function form(string $title, string $action, array $fields, $record = null, array $routeParameters = []): View { return view('admin.form', compact('title', 'action', 'fields', 'record', 'routeParameters')); }
}
