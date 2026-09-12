<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\OwnerController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');
Route::get('/customer/login', [AuthController::class, 'showCustomerLogin'])->name('customer.login');
Route::post('/customer/login', [AuthController::class, 'customerLogin'])->name('customer.login.process');
Route::get('/customer/register', [AuthController::class, 'showRegister'])->name('customer.register');
Route::post('/customer/register', [AuthController::class, 'register'])->name('customer.register.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/', [CustomerController::class, 'landing'])->name('home');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/products', [AdminController::class, 'products'])->name('admin.products.index');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
        Route::get('/stocks', [AdminController::class, 'stocks'])->name('admin.stocks.index');
        Route::get('/stocks/create', [AdminController::class, 'createStock'])->name('admin.stocks.create');
        Route::post('/stocks', [AdminController::class, 'storeStock'])->name('admin.stocks.store');
        Route::get('/stocks/{stock}/edit', [AdminController::class, 'editStock'])->name('admin.stocks.edit');
        Route::put('/stocks/{stock}', [AdminController::class, 'updateStock'])->name('admin.stocks.update');
        Route::delete('/stocks/{stock}', [AdminController::class, 'destroyStock'])->name('admin.stocks.destroy');
        Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers.index');
        Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('admin.payment-methods.index');
        Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('admin.payment-methods.create');
        Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('admin.payment-methods.store');
        Route::get('/payment-methods/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('admin.payment-methods.edit');
        Route::put('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('admin.payment-methods.update');
        Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('admin.payment-methods.destroy');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports.index');
        Route::get('/reports/print', [AdminController::class, 'printReport'])->name('admin.reports.print');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });


/*
|--------------------------------------------------------------------------
| PEMILIK
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pemilik'])
    ->prefix('pemilik')
    ->group(function () {

        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('pemilik.dashboard');
        Route::get('/products', [OwnerController::class, 'products'])->name('pemilik.products');
        Route::get('/stocks', [OwnerController::class, 'stocks'])->name('pemilik.stocks');
        Route::get('/transactions', [OwnerController::class, 'transactions'])->name('pemilik.transactions');
        Route::get('/reports', [OwnerController::class, 'report'])->name('pemilik.report');
        Route::get('/reports/print', [OwnerController::class, 'printReport'])->name('pemilik.report.print');
    });


/*
|--------------------------------------------------------------------------
| ADMIN PENJUALAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin_penjualan'])
    ->prefix('penjualan')
    ->group(function () {

        Route::get('/dashboard', [SalesController::class, 'dashboard'])->name('penjualan.dashboard');
        Route::get('/products', [SalesController::class, 'products'])->name('penjualan.products');
        Route::get('/stocks', [SalesController::class, 'stocks'])->name('penjualan.stocks');
        Route::get('/customers', [SalesController::class, 'customers'])->name('penjualan.customers');
        Route::get('/transactions/create', [SalesController::class, 'createTransaction'])->name('penjualan.transactions.create');
        Route::post('/transactions', [SalesController::class, 'storeTransaction'])->name('penjualan.transactions.store');
        Route::get('/transactions', [SalesController::class, 'history'])->name('penjualan.transactions.history');
        Route::get('/reports', [SalesController::class, 'report'])->name('penjualan.report');
        Route::get('/orders', [SalesController::class, 'orders'])->name('penjualan.orders');
        Route::patch('/orders/{transaction}/status', [SalesController::class, 'updateStatus'])->name('penjualan.orders.status');
    });


/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/products', [CustomerController::class, 'products'])->name('customer.products.index');
        Route::get('/products/{product}', [CustomerController::class, 'showProduct'])->name('customer.products.show');
        Route::get('/cart', [CustomerController::class, 'cart'])->name('customer.cart');
        Route::post('/cart', [CustomerController::class, 'addToCart'])->name('customer.cart.add');
        Route::patch('/cart/{product}', [CustomerController::class, 'updateCart'])->name('customer.cart.update');
        Route::delete('/cart/{product}', [CustomerController::class, 'removeFromCart'])->name('customer.cart.remove');
        Route::get('/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
        Route::post('/orders', [CustomerController::class, 'placeOrder'])->name('customer.orders.store');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders.index');
        Route::get('/orders/{transaction}', [CustomerController::class, 'order'])->name('customer.orders.show');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    });