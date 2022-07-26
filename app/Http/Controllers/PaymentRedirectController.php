<?php

namespace App\Http\Controllers;

class PaymentRedirectController extends Controller
{
    public function __invoke()
    {
        return redirect('dashboard')->withStatus('Payment accepted');
    }
}
