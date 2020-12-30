<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user_id = 3; // auth('api')->user()->id;
        $user = User::find($user_id);

        // $subscription = Subscription::whereStatus(1)->first();

        $stripe = new \Stripe\StripeClient(
            env("STRIPE_SECRET")
        );
        $payment = $stripe->prices->create([
            'unit_amount' => 10,
            'currency' => 'inr',
            'recurring' => ['interval' => 'month'],
            'product' => "prod_IH43av3bsoMNDz",
        ]);

        // dd($payment);

        $stripe = new \Stripe\StripeClient(
            env("STRIPE_SECRET")
        );
        $stripe->subscriptions->create([
            'customer' => "cus_IH4502QvPVkFr4",
            'items' => [
                [
                    'price' => $payment->id
                ],
            ],
        ]);
    }
}
