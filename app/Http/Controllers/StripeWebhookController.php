<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        \Log::info('Hello Stripe!');

        $payload = json_decode($request->getContent(), true);
        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['type']));

        \Log::info($method);

        if (method_exists($this, $method)) {
            return $this->{$method}($payload);
        }
    }

    protected function handlePaymentIntentSucceeded($payload)
    {
        // lookup the user
        $user = User::query()->findOrFail(Arr::get($payload, 'data.object.metadata.user_id'));

        // make user member
        $user->update([
            'member' => true,
        ]);

        \Log::info($user);
        // send user email
    }
}
