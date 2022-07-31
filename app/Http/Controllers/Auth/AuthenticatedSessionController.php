<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $cart = Cart::bySession()->first();

        $request->authenticate();

        $request->session()->regenerate();

        // If Cart record exists for the same user who is trying to login
        // Bring it over, update it's session_id with the newly generated one
        // This way, we link anonymous user (who have added products to cart before signing in)
        // with the new session after signing in.
        // Also update the user_id field to reflect the signed in user
        $cart?->update([
            'session_id' => session()->getId(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $cart = Cart::bySession()->first();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // After logging out, the user maintains the cart items
        // However, we need to update the session_id to reflect the newly created one
        $cart?->update([
            'session_id' => session()->getId(),
        ]);

        return redirect('/');
    }
}
