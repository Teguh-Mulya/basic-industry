<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(): View
    {
        return view('admin.payment-methods.index', [
            'paymentMethods' => PaymentMethod::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.payment-methods.form', ['paymentMethod' => null]);
    }

    public function store(Request $request)
    {
        PaymentMethod::create($request->validate([
            'name' => ['required', 'in:Tunai,Transfer Bank,QRIS,E-Wallet', 'unique:payment_methods,name'],
            'description' => ['nullable', 'string'],
            'account_number' => ['nullable', 'string', 'max:100'],
            'account_name' => ['nullable', 'string', 'max:100'],
            'details' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod): View
    {
        return view('admin.payment-methods.form', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $data = $request->validate([
            'name' => ['required', 'in:Tunai,Transfer Bank,QRIS,E-Wallet', 'unique:payment_methods,name,'.$paymentMethod->id],
            'description' => ['nullable', 'string'],
            'account_number' => ['nullable', 'string', 'max:100'],
            'account_name' => ['nullable', 'string', 'max:100'],
            'details' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $paymentMethod->update($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
