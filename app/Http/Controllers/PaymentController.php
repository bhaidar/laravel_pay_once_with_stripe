<?php

namespace App\Http\Controllers;

use App\Payments\PaymentGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentGateway $paymentGateway)
    {
    }

    public function __invoke(Request $request)
    {
        $this->paymentGateway->doPayment();
    }
}
