<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberIndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentIndexController;
use App\Http\Controllers\PaymentRedirectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDownloadController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\RedirectIfMember;
use App\Http\Middleware\RedirectIfNotMember;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\VerifyStripeWebhookSecret;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->prefix('/products')->group(function () {
    Route::get('/', ProductsController::class)->name('products');
    Route::get('/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/download/{product:slug}', [ProductDownloadController::class, 'show'])->name('products.download.show');
});

Route::middleware(['auth'])->prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/products', [CartProductController::class, 'store'])->name('cart.products.store');
    Route::delete('/products/{product:slug}', [CartProductController::class, 'destroy'])->name('cart.products.destroy');
});

Route::middleware(['auth'])->prefix('/checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/payment', PaymentController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/members', MemberIndexController::class)
        ->middleware([RedirectIfNotMember::class])
        ->name('members');

    Route::middleware([RedirectIfMember::class])->group(function () {
        Route::get('/payments', PaymentIndexController::class);

        Route::post('/payments/redirect', PaymentRedirectController::class)
            ->withoutMiddleware([VerifyCsrfToken::class])
            ->name('payments.redirect');
    });
});

Route::middleware(['auth'])->prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
});

// In case using Laravel Cashier
Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handleWebhook'])
    ->middleware([VerifyStripeWebhookSecret::class])
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Not using Laravel Cashier, for payment intent
// Route::post('/webhooks/stripe', StripeWebhookController::class)
//         ->middleware([VerifyStripeWebhookSecret::class])
//         ->withoutMiddleware([VerifyCsrfToken::class]);

require __DIR__.'/auth.php';
