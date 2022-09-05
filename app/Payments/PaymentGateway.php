<?php

namespace App\Payments;

interface PaymentGateway
{
    public function doPayment();
}
