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
        $user_id = auth('api')->user()->id;
        $user = User::find($user_id);

        $stripe = new \Stripe\StripeClient(
            env("STRIPE_SECRET", "sk_test_51I3hM1JH6V8eSiuB7r8Nr2JrthFKwmpwYOZHWBNWUJtayrQAihgPn9XSO97jDBlPjnF8QyoOXHVWnB4n7pIHwt8h00Fj8t88RY")
        );
        $payment = $stripe->prices->create([
            'unit_amount' => 10,
            'currency' => 'inr',
            'recurring' => ['interval' => 'month'],
            'product' => "prod_IH43av3bsoMNDz",
        ]);

        $stripe = new \Stripe\StripeClient(
            env("STRIPE_SECRET", "sk_test_51I3hM1JH6V8eSiuB7r8Nr2JrthFKwmpwYOZHWBNWUJtayrQAihgPn9XSO97jDBlPjnF8QyoOXHVWnB4n7pIHwt8h00Fj8t88RY")
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
