<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\User;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function webhookCallback(Request $request)
    {
        $stripe_data = $request->all();

        if ($stripe_data['type'] === 'customer.subscription.updated') {
            $stripe_subscription = $stripe_data['data']['object'] ?? [];
            if (isset($stripe_subscription['id']) && !empty($stripe_subscription['id'])) {

                $user = User::whereStripeId($stripe_subscription['customer'])->first();
                if (empty($user) || !isset($user->id)) {
                    info("Stripe invaild customer - " . $stripe_subscription['customer']);
                    return response()->json(['status' => false]);
                }

                $user_subscription = UserSubscription::where('stripe_subscription_id', $stripe_subscription['id'])->first();
                if (!empty($user_subscription) && isset($user_subscription->id) && $user_subscription->subscription_status === 1) {

                    $subscription = Subscription::find($user_subscription->subscription_id);
                    if (empty($subscription) || !isset($subscription->id)) {
                        info("Database invaild subscription - " . $stripe_subscription['id']);
                        return response()->json(['status' => false]);
                    }

                    $order = Order::find($user_subscription->order_id);

                    $cart_total = $subscription->price ?? 0;
                    $delivery_fee = $order->delivery_fee; // Setting::whereSeetingKey('delivery_fee')->first()->setting_value ?? 0;
                    $subtotal = $cart_total + $delivery_fee;

                    $tax_charges = Setting::whereSeetingKey('tax_charges')->first()->setting_value ?? 0;
                    $total_amount = $subtotal + $tax_charges;

                    $order_data = [
                        'user_id' => $user->id,
                        'address_id' => $order->id,
                        'order_number' => time(),
                        'order_type' => 'subscription',

                        'cart_total' => $cart_total,
                        'delivery_fee' => $delivery_fee,

                        'promocode' => null,
                        'promocode_amount' => null,

                        'subtotal' => $subtotal,
                        'tax_charges' => $tax_charges,
                        'total_amount' => $total_amount,
                        'payment_received' => $total_amount,

                        'payment_type' => 'card',
                        'card_type' => $order->card_type,
                        'card_number' => $order->card_number,
                        'customer_note' => null,
                        'reward_points' => 0,
                    ];

                    $order = Order::create($order_data);
                    if (!empty($order) && isset($order->id)) {

                        OrderDetail::create([
                            'order_id' => $order->id,
                            'stripe_subscription_id' => $stripe_subscription['id'],
                            'subscription_id' => $subscription->id,
                            'quantity' => 1,
                            'amount' => $subscription->price,
                            'subtotal' => $subscription->price,
                        ]);

                        UserSubscription::create([
                            'user_id' => $order->user_id,
                            'order_id' => $order->id,
                            'subscription_id' => $subscription->id,
                            'stripe_subscription_id' => $stripe_subscription['id'],
                            'start_date' => date("Y-m-d H:i:s"),
                            'end_date' => date("Y-m-d H:i:s", strtotime("+30 days")),
                            'billing_date' => date("Y-m-d H:i:s"),
                            'subscription_status' => 1,
                        ]);

                        Transaction::create([
                            'order_id' => $order->id,
                            'payment_id' => $stripe_subscription['latest_invoice'] ?? "N/A",
                            'type' => 'card',
                            'payment_type' => 'payment',
                            'amount' => $subscription->price
                        ]);
                        $order->payment_received = $subscription->price;
                        $order->save();

                        $subscription_data = [
                            'order_id' => $order->id,
                            'order_data' => $order
                        ];
                        \OneSignal::sendNotificationToUser("Your subscription order has been generated", $user->device_token, null, $subscription_data);

                        return response()->json(['status' => true]);
                    } else {
                        info("Database orde create error");
                        info(print_r($order_data, true));
                    }
                } else {
                    info("Stripe invaild subscription - " . $stripe_subscription['id']);
                }
            } else {
                info("Stripe id missing");
            }
        }
        return response()->json(['status' => false]);
    }
}
