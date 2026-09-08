<?php

use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mekanik\AssistanceRequestController;
use App\Http\Controllers\Mekanik\EmergencyController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\OilController;
use App\Http\Controllers\Pengguna\BookingController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TireController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/servis', [ServisController::class, 'index'])->name('servis');
Route::get('/servis/{slug}', [ServisController::class, 'show'])->name('servis.detail');
Route::redirect('/toko', '/')->name('toko.index');
Route::get('/toko/show/{id}', [TokoController::class, 'show'])->name('toko.show');
Route::get('/toko/checkout/{id}', [TokoController::class, 'checkout'])->name('toko.checkout')->middleware(['auth', 'role:pengguna']);
Route::get('/toko/hasil/{purchase}', [TokoController::class, 'result'])->name('toko.result')->middleware(['auth', 'role:pengguna']);
Route::post('/toko/buy/{id}', [TokoController::class, 'buy'])->name('toko.buy')->middleware(['auth', 'role:pengguna']);
Route::get('/toko/ban-motor', [TireController::class, 'index'])->name('toko.banmotor');
Route::get('/toko/ban-motor/{id}', [TireController::class, 'show'])->name('toko.banmotor.show');
Route::get('/toko/ban-motor/checkout/{id}', [TireController::class, 'checkout'])->name('toko.banmotor.checkout')->middleware(['auth', 'role:pengguna']);
Route::post('/toko/ban-motor/buy/{id}', [TireController::class, 'buy'])->name('toko.banmotor.buy')->middleware(['auth', 'role:pengguna']);
Route::get('/toko/oli-motor', [OilController::class, 'index'])->name('toko.oli');
Route::get('/toko/oli-motor/{id}', [OilController::class, 'show'])->name('toko.oli.show');
Route::get('/toko/oli-motor/checkout/{id}', [OilController::class, 'checkout'])->name('toko.oli.checkout')->middleware(['auth', 'role:pengguna']);
Route::post('/toko/oli-motor/buy/{id}', [OilController::class, 'buy'])->name('toko.oli.buy')->middleware(['auth', 'role:pengguna']);
Route::get('/toko/sparepart', [SparepartController::class, 'index'])->name('toko.sparepart');
Route::get('/toko/sparepart/{id}', [SparepartController::class, 'show'])->name('toko.sparepart.show');
Route::get('/toko/sparepart/checkout/{id}', [SparepartController::class, 'checkout'])->name('toko.sparepart.checkout')->middleware(['auth', 'role:pengguna']);
Route::post('/toko/sparepart/buy/{id}', [SparepartController::class, 'buy'])->name('toko.sparepart.buy')->middleware(['auth', 'role:pengguna']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register')->name('register.process');

Route::get('/booking/{slug}', [BookingController::class, 'create'])->name('booking.create')->middleware(['auth', 'role:pengguna']);
Route::post('/booking/{slug}', [BookingController::class, 'store'])->name('booking.store')->middleware(['auth', 'role:pengguna']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::middleware('role:pengguna')->group(function () {
        Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::post('/cart/buy', [CartController::class, 'buy'])->name('cart.buy');
        Route::get('/cart/result', [CartController::class, 'result'])->name('cart.result');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class);
        Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class)->only(['index', 'show', 'update']);
        Route::resource('tires', App\Http\Controllers\Admin\TireController::class)->except(['index', 'show', 'create', 'edit']);
        Route::resource('oils', App\Http\Controllers\Admin\OilController::class)->except(['index', 'show', 'create', 'edit']);
        Route::resource('spareparts', App\Http\Controllers\Admin\SparepartController::class)->except(['index', 'show', 'create', 'edit']);
        Route::resource('products', ProductController::class)->only(['store', 'update', 'destroy']);

        // Admin Payments
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
            Route::post('/{payment}/simulate', [PaymentController::class, 'simulate'])->name('simulate');
        });
    });

    Route::middleware('role:mekanik')->prefix('mekanik')->name('mekanik.')->group(function () {
        Route::get('/dashboard', [MekanikController::class, 'dashboard'])->name('dashboard');
        Route::get('/bookings', [App\Http\Controllers\Mekanik\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [App\Http\Controllers\Mekanik\BookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{booking}', [App\Http\Controllers\Mekanik\BookingController::class, 'update'])->name('bookings.update');
        Route::get('/emergency', [EmergencyController::class, 'index'])->name('emergency.index');
        Route::get('/emergency/{emergency}', [EmergencyController::class, 'show'])->name('emergency.show');
        Route::put('/emergency/{emergency}', [EmergencyController::class, 'update'])->name('emergency.update');
        Route::get('/assistance-requests', [AssistanceRequestController::class, 'index'])->name('assistance-requests.index');
        Route::post('/emergency/{emergency}/assistance-requests', [AssistanceRequestController::class, 'store'])->name('assistance-requests.store');
        Route::get('/assistance-requests/{assistanceRequest}', [AssistanceRequestController::class, 'show'])->name('assistance-requests.show');
        Route::patch('/assistance-requests/{assistanceRequest}/accept', [AssistanceRequestController::class, 'accept'])->name('assistance-requests.accept');
        Route::patch('/assistance-requests/{assistanceRequest}/reject', [AssistanceRequestController::class, 'reject'])->name('assistance-requests.reject');
        Route::patch('/assistance-requests/{assistanceRequest}/cancel', [AssistanceRequestController::class, 'cancel'])->name('assistance-requests.cancel');
        Route::patch('/assistance-requests/{assistanceRequest}/complete', [AssistanceRequestController::class, 'complete'])->name('assistance-requests.complete');
    });

    Route::middleware('role:pengguna')->prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/dashboard', [PenggunaController::class, 'dashboard'])->name('dashboard');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/emergency', [App\Http\Controllers\Pengguna\EmergencyController::class, 'index'])->name('emergency.index');
        Route::get('/emergency/create', [App\Http\Controllers\Pengguna\EmergencyController::class, 'create'])->name('emergency.create');
        Route::post('/emergency', [App\Http\Controllers\Pengguna\EmergencyController::class, 'store'])->name('emergency.store');
        Route::get('/emergency/{emergency}', [App\Http\Controllers\Pengguna\EmergencyController::class, 'show'])->name('emergency.show');
    });

    Route::middleware('role:pengguna')->prefix('pengguna/payments')->name('pengguna.payments.')->group(function () {
        Route::get('/{payment}', [App\Http\Controllers\Pengguna\PaymentController::class, 'show'])->name('show');
        Route::post('/{payment}/select-method', [App\Http\Controllers\Pengguna\PaymentController::class, 'selectMethod'])->name('select-method');
        Route::post('/{payment}/pay', [App\Http\Controllers\Pengguna\PaymentController::class, 'pay'])->name('pay');
        Route::get('/{payment}/success', [App\Http\Controllers\Pengguna\PaymentController::class, 'success'])->name('success');
        Route::get('/{payment}/expired', [App\Http\Controllers\Pengguna\PaymentController::class, 'expired'])->name('expired');
    });
});
