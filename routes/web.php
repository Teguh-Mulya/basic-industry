<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });


/*
|--------------------------------------------------------------------------
| PEMILIK
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pemilik'])
    ->prefix('pemilik')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pemilik.dashboard');
        })->name('pemilik.dashboard');
    });


/*
|--------------------------------------------------------------------------
| ADMIN PENJUALAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin_penjualan'])
    ->prefix('penjualan')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('penjualan.dashboard');
        })->name('penjualan.dashboard');
    });


/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('customer.dashboard');
    });