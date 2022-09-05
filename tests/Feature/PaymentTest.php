<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Payments\PaymentGateway;
use App\Payments\PaypalGateway;
use Mockery;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function test_the_payment_endpoint_returns_a_successful_response()
    {
        // Create a  mock
        $mock = Mockery::mock(PaypalGateway::class)->makePartial();

        // Set expectations
        $mock->shouldReceive('doPayment')
            ->once()
            ->andReturnNull();

        // Add this mock to the service container to take the service class' place.
        app()->instance(PaymentGateway::class, $mock);

        // Run endpoint
        $this->get('/payment')->assertStatus(200);
    }
}
