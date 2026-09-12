<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SalesController extends Controller
{
    private const STATUSES = ['Menunggu Persetujuan', 'Diproses', 'Dikirim', 'Selesai'];

    public function dashboard(): View
    {
        $monthlySales = $this->monthlySales();

        return view('penjualan.dashboard', [
            'transactionCount' => Transaction::count(),
            'todaySales' => Transaction::whereDate('transaction_date', today())->sum('total_amount'),
            'customerCount' => User::where('role', 'customer')->count(),
            'productCount' => Product::count(),
            'transactions' => $this->transactions()->take(8)->get(),
            'monthlySales' => $monthlySales,
            'monthlySalesMax' => max(1, $monthlySales->max('total')),
        ]);
    }

    public function products(): View
    {
        return view('penjualan.products', ['products' => Product::with(['category', 'stock'])->latest()->get()]);
    }

    public function stocks(): View
    {
        return view('penjualan.stocks', ['stocks' => Stock::with('product')->latest()->get()]);
    }

    public function customers(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $customers = User::where('role', 'customer')
            ->when($search !== '', fn ($query) => $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->latest()
            ->get();

        return view('penjualan.customers', compact('customers', 'search'));
    }

    public function createTransaction(): View
    {
        return view('penjualan.transactions-create', [
            'customers' => Customer::orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function storeTransaction(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::exists('payment_methods', 'name')->where('is_active', true)],
            'transaction_date' => ['required', 'date'],
        ]);
        $data['transaction_code'] = 'TRX-'.now()->format('YmdHis').'-'.random_int(100, 999);
        $data['user_id'] = auth()->id();
        $data['status'] = 'Diproses';
        Transaction::create($data);

        return redirect()->route('penjualan.transactions.history')->with('success', 'Transaksi penjualan berhasil dibuat.');
    }

    public function history(): View
    {
        return view('penjualan.transactions', ['transactions' => $this->transactions()->get(), 'heading' => 'Riwayat Transaksi']);
    }

    public function report(Request $request): View
    {
        $from = $request->date('from');
        $to = $request->date('to');
        $transactions = $this->transactions()
            ->when($from, fn ($query) => $query->whereDate('transaction_date', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('transaction_date', '<=', $to))
            ->get();

        return view('penjualan.report', [
            'transactions' => $transactions,
            'from' => $from?->format('Y-m-d'),
            'to' => $to?->format('Y-m-d'),
            'transactionCount' => $transactions->count(),
            'salesTotal' => $transactions->sum('total_amount'),
            'completedCount' => $transactions->where('status', 'Selesai')->count(),
        ]);
    }

    public function orders(): View
    {
        return view('penjualan.orders', ['transactions' => $this->transactions()->whereIn('status', ['Menunggu Persetujuan', 'Diproses', 'Dikirim'])->get()]);
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', self::STATUSES)],
        ]);

        $transaction->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    private function transactions()
    {
        return Transaction::with('customer')->latest('transaction_date');
    }

    private function monthlySales()
    {
        $startMonth = now()->startOfMonth()->subMonths(5);

        return collect(range(0, 5))->map(function (int $offset) use ($startMonth) {
            $month = $startMonth->copy()->addMonths($offset);

            return [
                'label' => $month->translatedFormat('M Y'),
                'total' => (float) Transaction::whereBetween('transaction_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->sum('total_amount'),
            ];
        });
    }
}
