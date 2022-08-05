<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::bySession()->with('products')->first();

        $checkout = $request->user()->checkout(
            $cart->products->pluck('stripe_id')->toArray(),
            [
                'success_url' => route('dashboard'),
                'cancel_url' => route('checkout.index'),
            ]
        );

        return Inertia::render('Checkout/Index', [
            'checkoutSessionId' => $checkout->id,
        ]);
    }
}
