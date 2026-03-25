<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InnerCircleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\HomeSettingController;
use App\Http\Controllers\Admin\SalesOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - LUXE Premium Store & Admin Portal
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN UTAMA & PENCARIAN (PUBLIC) ---
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// SCRIPT ANTI-KADALUARSA (CSRF Heartbeat) - Penting untuk mencegah error 419
Route::get('/refresh-csrf', function () {
    return response()->json(['status' => 'refreshed', 'timestamp' => now()]);
})->name('refresh.csrf');

// --- 2. GRUP RUTE SUPPORT & LEGAL ---
Route::prefix('support')->group(function () {
    Route::get('/team', [SupportController::class, 'team'])->name('support.team');
    Route::get('/shipping', [SupportController::class, 'shipping'])->name('support.shipping');
    Route::get('/returns', [SupportController::class, 'returns'])->name('support.returns');
    Route::get('/faq', [SupportController::class, 'faq'])->name('support.faq');
    Route::get('/privacy-policy', [SupportController::class, 'privacy'])->name('support.privacy');
    Route::get('/terms-of-service', [SupportController::class, 'terms'])->name('support.terms');
});

// --- 3. RUTE AUTENTIKASI USER (Pelanggan / Guard: web) ---
Route::middleware('guest')->group(function () {
    Route::get('/loginuser', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/loginuser', [AuthController::class, 'login']);
    
    Route::get('/registeruser', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registeruser', [AuthController::class, 'register']);

    // Password Reset System
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// --- 4. RUTE TERPROTEKSI PELANGGAN (Guard: web) ---
Route::middleware(['auth'])->group(function () {
    // A. Detail Produk & Filter Khusus
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/product/verify-voucher', [ProductController::class, 'verifyVoucher'])->name('products.verify_voucher');
    Route::get('/collection/deals', [ProductController::class, 'showDeals'])->name('products.deals');
    Route::get('/collection/vouchers', [ProductController::class, 'showVouchers'])->name('products.vouchers');

    // B. MANAJEMEN INNER CIRCLE (Subscriber Only)
    Route::post('/subscribe-circle', [InnerCircleController::class, 'subscribe'])->name('subscribe.circle');
    Route::get('/inner-circle', [InnerCircleController::class, 'index'])->name('inner.circle');

    // C. Manajemen Keranjang Belanja (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    // D. Sistem Checkout & Dashboard Pesanan Pelanggan
    Route::post('/checkout/payment', [CheckoutController::class, 'index'])->name('checkout.payment');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('orders.index_user');
    Route::get('/order-history', [CheckoutController::class, 'history'])->name('orders.history');
    Route::post('/my-orders/{id}/confirm', [CheckoutController::class, 'confirmReceived'])->name('orders.confirm');

    // E. Logout Pelanggan
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// --- 5. SOCIAL AUTH CONNECTORS ---
Route::prefix('auth')->group(function () {
    Route::get('/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);
    Route::get('/apple', [AuthController::class, 'redirectToApple'])->name('auth.apple');
    Route::get('/apple/callback', [AuthController::class, 'handleAppleCallback']);
});

// --- 6. BACKEND ADMIN ROUTES (Guard: admin) ---
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Login Admin
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Area Terproteksi Admin (Guard: admin & Gate: access-admin)
    Route::middleware(['auth:admin', 'can:access-admin'])->group(function () {
        
        // Dashboard Overview
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // SALES ORDERS MANAGEMENT (ADMIN)
        Route::get('/sales-orders', [SalesOrderController::class, 'index'])->name('orders.index');
        Route::get('/sales-orders/export-pdf', [SalesOrderController::class, 'exportPDF'])->name('orders.exportPDF');
        Route::get('/sales-orders/{id}', [SalesOrderController::class, 'show'])->name('orders.show');
        Route::patch('/sales-orders/{id}/update-status', [SalesOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('/sales-orders/{id}', [SalesOrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/sales-orders/{id}/print-receipt', [SalesOrderController::class, 'printReceipt'])->name('orders.print');

        // CIRCLE LUXE BROADCAST MANAGEMENT (ADMIN)
        Route::get('/circle-broadcast', [SalesOrderController::class, 'circleIndex'])->name('circle.index');
        Route::post('/circle-broadcast/store', [SalesOrderController::class, 'circleStore'])->name('circle.store');
        Route::delete('/circle-broadcast/{id}', [SalesOrderController::class, 'circleDestroy'])->name('circle.destroy');
        Route::patch('/circle-broadcast/{id}/update', [SalesOrderController::class, 'circleUpdate'])->name('circle.update');

        // CMS EDITORS (Setting Halaman Dinamis)
        Route::get('/home-settings', [HomeSettingController::class, 'index'])->name('home.settings');
        Route::post('/home-settings/update', [HomeSettingController::class, 'update'])->name('home.settings.update');
        Route::get('/login-settings', [HomeSettingController::class, 'loginIndex'])->name('login.settings');
        Route::post('/login-settings/update', [HomeSettingController::class, 'loginUpdate'])->name('login.settings.update');
        Route::get('/register-settings', [HomeSettingController::class, 'registerIndex'])->name('register.settings');
        Route::post('/register-settings/update', [HomeSettingController::class, 'registerUpdate'])->name('register.settings.update');
        Route::get('/forgot-settings', [HomeSettingController::class, 'forgotIndex'])->name('forgot.settings');
        Route::post('/forgot-settings/update', [HomeSettingController::class, 'forgotUpdate'])->name('forgot.settings.update');
        Route::get('/reset-settings', [HomeSettingController::class, 'resetIndex'])->name('reset.settings');
        Route::post('/reset-settings/update', [HomeSettingController::class, 'resetUpdate'])->name('reset.settings.update');
        
        // E-COMMERCE & INVENTORY MANAGEMENT
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit_json');
        Route::post('/products/update/{id}', [AdminProductController::class, 'update'])->name('products.update_manual');
        Route::delete('/products/destroy/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy_manual');
        Route::resource('products', AdminProductController::class);

        // Logout Admin
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});