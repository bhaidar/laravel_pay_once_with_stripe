<?php

namespace App\Payments;

class PaypalGateway implements PaymentGateway
{
    public function __construct(protected string $secretKey)
    {
    }

    public function doPayment()
    {
        echo 'doPayment called';
    }
}
