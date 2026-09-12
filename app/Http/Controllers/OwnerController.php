<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerController extends Controller
{
    public function dashboard(): View
    {
        $monthlySales = $this->monthlySales();

        return view('pemilik.dashboard', [
            'productCount' => Product::count(),
            'stockTotal' => Stock::sum('quantity'),
            'transactionCount' => Transaction::count(),
            'salesTotal' => Transaction::sum('total_amount'),
            'transactions' => $this->transactionQuery()->take(8)->get(),
            'monthlySales' => $monthlySales,
            'monthlySalesMax' => max(1, $monthlySales->max('total')),
        ]);
    }

    public function products(): View
    {
        return view('pemilik.products', ['products' => Product::with(['category', 'stock'])->latest()->get()]);
    }

    public function stocks(): View
    {
        return view('pemilik.stocks', ['stocks' => Stock::with('product')->latest()->get()]);
    }

    public function transactions(): View
    {
        return view('pemilik.transactions', ['transactions' => $this->transactionQuery()->get()]);
    }

    public function report(Request $request): View
    {
        $from = $request->date('from');
        $to = $request->date('to');
        $transactions = $this->filteredTransactions($from, $to)->get();

        return view('pemilik.report', [
            'transactions' => $transactions,
            'from' => $from?->format('Y-m-d'),
            'to' => $to?->format('Y-m-d'),
            'transactionCount' => $transactions->count(),
            'salesTotal' => $transactions->sum('total_amount'),
        ]);
    }

    public function printReport(Request $request): View
    {
        $from = $request->date('from');
        $to = $request->date('to');
        $transactions = $this->filteredTransactions($from, $to)->get();

        return view('pemilik.report-print', [
            'transactions' => $transactions,
            'from' => $from?->format('d/m/Y'),
            'to' => $to?->format('d/m/Y'),
            'salesTotal' => $transactions->sum('total_amount'),
        ]);
    }

    private function transactionQuery()
    {
        return Transaction::with('customer')->latest('transaction_date');
    }

    private function filteredTransactions($from, $to)
    {
        return $this->transactionQuery()
            ->when($from, fn ($query) => $query->whereDate('transaction_date', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('transaction_date', '<=', $to));
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
