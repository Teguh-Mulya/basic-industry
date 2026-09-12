<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.customer-register');
    }

    public function showCustomerLogin()
    {
        return view('auth.customer-login');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password']), 'role' => 'customer']);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('customer.dashboard');
    }

    /**
     * Memproses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (! in_array($user->role, ['admin', 'pemilik', 'admin_penjualan'], true)) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun customer harus menggunakan login customer.'])->onlyInput('email');
            }

            // Arahkan pengguna berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');

                case 'pemilik':
                    return redirect()->route('pemilik.dashboard');

                case 'admin_penjualan':
                    return redirect()->route('penjualan.dashboard');

                default:
                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([
                            'email' => 'Role pengguna tidak dikenali.',
                        ]);
            }
        }

        return back()
            ->withErrors([
                'email' => 'Gunakan login customer untuk akun customer, atau periksa email dan password.',
            ])
            ->onlyInput('email');
    }

    public function customerLogin(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role !== 'customer') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini menggunakan login internal.'])->onlyInput('email');
            }
            return redirect()->route('customer.dashboard');
        }
        return back()->withErrors(['email' => 'Login customer gagal. Periksa email dan password.'])->onlyInput('email');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}