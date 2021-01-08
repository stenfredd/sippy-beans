<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Mail\AppNewOrder;
use App\Mail\CustomerNewOrder;
use App\Mail\MerchantNewOrder;
use App\Models\Grind;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Seller;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

                        // $subscription_data = [
                        //     'order_id' => $order->id,
                        //     'order_data' => $order
                        // ];
                        // \OneSignal::sendNotificationToUser("Your subscription order has been generated", $user->device_token, null, $subscription_data);

                        ////////////////////////////////////////////////////////////

                        $order = Order::with([
                            'user', 'address', 'details',
                            'details.product', 'details.variant', 'details.equipment', 'details.subscription',
                            'details.product.seller', 'details.equipment.seller',
                            'details.product.images', 'details.equipment.images'
                        ])
                            ->find($order->id);

                        $order->total_refund = Transaction::wherePaymentType('refund')->sum('amount');
                        $order->balance = $order->total_amount - $order->payment_received - $order->total_refund;
                        $order->total_discount = $order->promocode_amount ?? 0;
                        if (!empty($order->discount_type) && !empty($order->discount_amount)) {
                            $discount_amount = ($order->discount_type == 'percentage' ? (($order->total_amount / 100) * $order->discount_amount) : $order->discount_amount);
                            $order->total_discount = $order->total_discount + $discount_amount;
                        }
                        $order->created_at_text = $order->created_at->timezone($this->app_settings['timezone'])->format("M d, Y, h:iA") ?? $order->created_at;
                        $order->product_names = null;
                        if ($order->order_type == 'subscription') {
                            $order->product_names = $order->subscription->title ?? '';
                        }
                        else {
                            foreach ($order->details as $detail) {
                                if (!empty($detail->product) && isset($detail->product->product_name)) {
                                    $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->product->product_name;
                                }
                            }
                            // if(empty($order->product_names)) {
                            foreach ($order->details as $detail) {
                                if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                                    $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->equipment->title;
                                }
                            }
                            // }
                        }
                        foreach ($order->details as $detail) {
                            $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
                        }
                        $order->delivery_time = $order->address->city()->first()->delivery_time ?? '1-3 Business days';

                        Mail::to($order->user->email)->queue(new CustomerNewOrder($order));
                        try {
                            Mail::to(env('APP_ORDER_EMAIL', 'mohitodhrani@gmail.com'))->queue(new AppNewOrder($order));
                        }
                        catch (\Exception $e) {
                            info($e->getMessage());
                        }

                        $seller_details = [];
                        foreach ($order->details as $detail) {
                            if (!empty($detail->subscription_id)) {
                                continue;
                            }
                            if (!empty($detail->equipment_id)) {
                                $commission_fee = 0;
                                if ($detail->equipment->commission_type === 'percentage') {
                                    $commission_fee = ($detail->subtotal / 100) * $detail->equipment->commission_fee;
                                }
                                else {
                                    $commission_fee = $detail->equipment->commission_fee * $detail->quantity;
                                }
                                $detail->seller_price = $detail->subtotal - $commission_fee;
                                $seller_details[$detail->equipment->seller->id][] = $detail;
                            }
                            if (!empty($detail->product_id)) {
                                $commission_fee = 0;
                                if ($detail->product->commission_type === 'percentage') {
                                    $commission_fee = ($detail->subtotal / 100) * $detail->product->commission_fee;
                                }
                                else {
                                    $commission_fee = $detail->product->commission_fee * $detail->quantity;
                                }
                                $detail->seller_price = $detail->subtotal - $commission_fee;
                                $seller_details[$detail->product->seller->id][] = $detail;
                            }
                        }

                        if (!empty($seller_details)) {
                            foreach ($seller_details as $seller_id => $details) {
                                $seller = Seller::find($seller_id);
                                $order->seller_total = array_sum(array_column($details, "seller_price"));
                                Mail::to($seller->seller_email)->queue(new MerchantNewOrder($order, $details, $seller));
                            }
                        }

                        ////////////////////////////////////////////////////////////

                        return response()->json(['status' => true]);
                    }
                    else {
                        info("Database order create error");
                        info(print_r($order_data, true));
                    }
                }
                else {
                    info("Stripe invaild subscription - " . $stripe_subscription['id']);
                }
            }
            else {
                info("Stripe id missing");
            }
        }
        return response()->json(['status' => false]);
    }
}
