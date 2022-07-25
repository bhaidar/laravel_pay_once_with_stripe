<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $paymentIntent = app('stripe')->paymentIntents->create([
            'amount' => 10000, // cents
            'currency' => 'usd',
            'setup_future_usage' => 'on_session', // https://stripe.com/docs/api/payment_intents/create#create_payment_intent-setup_future_usage
            'metadata' => [
                'user_id' => (string) $request->user()->id,
            ],
        ]);

        return Inertia::render('Payments/Index', ['paymentIntent' => $paymentIntent]);
    }
}
