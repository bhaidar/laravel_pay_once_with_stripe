<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberIndexController;
use App\Http\Controllers\PaymentIndexController;
use App\Http\Controllers\PaymentRedirectController;
use App\Http\Controllers\StripeWebhookController;
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

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])
    ->group(function () {
        Route::get('/members', MemberIndexController::class)
            ->middleware([RedirectIfNotMember::class]);

        Route::middleware([RedirectIfMember::class])
            ->group(function () {
                Route::get('/payments', PaymentIndexController::class);

                Route::post('/payments/redirect', PaymentRedirectController::class)
                    ->withoutMiddleware([VerifyCsrfToken::class])
                    ->name('payments.redirect');
            });
    });

    Route::post('/webhooks/stripe', StripeWebhookController::class)
    ->middleware([VerifyStripeWebhookSecret::class])
    ->withoutMiddleware([VerifyCsrfToken::class]);

require __DIR__.'/auth.php';
