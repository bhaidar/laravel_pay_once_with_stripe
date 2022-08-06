<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

//class StripeWebhookController extends Controller

// In case, using Cashier, extend CashierWebhookController
class StripeWebhookController extends CashierWebhookController
{
    protected function handleCheckoutSessionCompleted($payload)
    {
        // Copied from CashierWebhookController
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            // Bring the user cart
            $cart = $user->cart;

            // Create order
            $order = $user->orders()->create();
        }
    }

    /**
     * Enable only when handling payment intent with payment elements or card
     * In this case, no need for Laravel Cashier
     *
     * @param  mixed  $payload
     * @return void
     */
    // protected function handlePaymentIntentSucceeded($payload)
    // {
    //     // lookup the user
    //     $user = User::query()->findOrFail(Arr::get($payload, 'data.object.metadata.user_id'));

    //     // make user member
    //     $user->update([
    //         'member' => true,
    //     ]);

    //     \Log::info($user);
    //     // send user email
    // }
}
