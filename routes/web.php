<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberIndexController;
use App\Http\Controllers\PaymentIndexController;
use App\Http\Controllers\PaymentRedirectController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\RedirectIfNotMember;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

        Route::prefix('/payments')
            ->group(function () {
                Route::get('/', PaymentIndexController::class);

                Route::post('/redirect', PaymentRedirectController::class)
                ->withoutMiddleware([VerifyCsrfToken::class])
                ->name('payments.redirect');
            });
    });

    Route::post('/webhooks/stripe', StripeWebhookController::class)
        ->withoutMiddleware([VerifyCsrfToken::class]);

    require __DIR__.'/auth.php';
