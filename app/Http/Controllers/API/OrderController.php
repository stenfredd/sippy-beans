<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\AppNewOrder;
use App\Mail\CustomerNewOrder;
use App\Mail\MerchantNewOrder;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Promocode;
use App\Models\RedeemPromocode;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserPromocode;
use App\Models\UserSubscription;
use App\Models\Subscription;
use App\Models\Image;
use App\Models\Grind;
use App\Models\Seller;
use App\UserReward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = auth('api')->user()->id ?? null;

        $orders = Order::whereUserId($user_id)
            ->with([
                'address', 'details',
                'details.product', 'details.product.brand',
                'details.variant', 'details.variant.images',
                'details.equipment', 'details.equipment.brand', 'details.equipment.images',
                'details.subscription'
            ])
            ->latest()
            ->paginate(20);

        foreach ($orders as $order) {

            $order->total_refund = 0;
            $order->pending_refund = 0;
            // $cancelled_items_amount = OrderDetail::whereOrderId($order->id)->whereIsCancelled(1)->sum('subtotal');
            $cancelled_items_amount = 0;
            $cancelled_items_arr = OrderDetail::whereOrderId($order->id)->whereIsCancelled(1)->get();
            if(!empty($cancelled_items_arr) && count($cancelled_items_arr) > 0) {
                foreach ($cancelled_items_arr as $cancelItem) {
                    $cancelled_items_amount = $cancelled_items_amount + ($cancelItem->cancel_quantity * $cancelItem->amount);
                }
            }
            $order->total_refund = Transaction::whereOrderId($order->id)->wherePaymentType('refund')->sum('amount');
            if ($cancelled_items_amount > 0) {
                if (OrderDetail::whereOrderId($order->id)->count() == OrderDetail::whereOrderId($order->id)->whereIsCancelled(1)->count()) {
                    if ($order->pending_refund == 0) {
                        Order::find($order->id)->update(['payment_status' => 4]);
                    } else {
                        Order::find($order->id)->update(['payment_status' => 3]);
                    }
                    $cancelled_items_amount = $cancelled_items_amount + $order->delivery_fee + $order->tax_charges;
                }
                $order->pending_refund = $cancelled_items_amount - $order->total_refund;
            }
            $order->balance = $order->total_amount - $order->payment_received - $order->total_discount - $cancelled_items_amount;
            $order->balance = $order->balance - (($order->balance < 0 ? '-' : '') . $order->total_refund);

            // $order->total_refund = Transaction::wherePaymentType('refund')->sum('amount');
            // $order->balance = $order->total_amount - $order->payment_received - $order->total_refund;
            $order->total_discount = $order->promocode_amount ?? 0;
            if (!empty($order->discount_type) && !empty($order->discount_amount)) {
                $discount_amount = ($order->discount_type == 'percentage' ? (($order->total_amount / 100) * $order->discount_amount) : $order->discount_amount);
                $order->total_discount = $order->total_discount + $discount_amount;
            }
            $order->created_at_text = $order->created_at->timezone($this->app_settings['timezone'])->format("M d, Y, h:iA") ?? $order->created_at;
            $order->product_names = null;
            if ($order->order_type == 'subscription') {
                $order->subscription = Subscription::whereStatus(1)->first();
                $order->product_names = "SIPPY - " . ($order->subscription->title ?? '') . ' x1';
            } else {
                foreach ($order->details as $detail) {
                    if (!empty($detail->product) && isset($detail->product->product_name)) {
                        $name = ($detail->product->brand->name ?? '') . ' - ' . $detail->product->product_name . ' x' . $detail->quantity;
                        $order->product_names .= (!empty($order->product_names) ? ', ' : '') . $name;
                    }
                }
                // if(empty($order->product_names)) {
                foreach ($order->details as $detail) {
                    if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                        $name = ($detail->equipment->brand->name ?? '') . ' - ' . $detail->equipment->title . ' x' . $detail->quantity;
                        $order->product_names .= (!empty($order->product_names) ? ', ' : '') . $name;
                    }
                }
                // }
            }
            foreach ($order->details as $detail) {
                $detail->image_url = '';
                if (!empty($detail->subscription_id)) {
                    $detail->image_url = Subscription::find($detail->subscription_id)->image_url ?? null;
                    $detail->brand_name = "SIPPY";
                    $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
                }
                if (!empty($detail->equipment_id)) {
                    $detail->image_url = Image::whereType('equipment')->whereContentId($detail->equipment_id)->first()->image_path ?? null;
                }
                if (!empty($detail->variant_id)) {
                    $detail->image_url = Image::whereType('product')->whereContentId($detail->product_id)->first()->image_path ?? null;
                    $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
                }
            }
            $order->delivery_time = $order->address->city()->first()->delivery_time ?? '1-3 Business days';
        }

        $response = ['status' => false, 'message' => 'You have no recent orders.'];
        if (!empty($orders) && count($orders) > 0) {
            $response = [
                'status' => true,
                'total_pages' => $orders->lastPage(),
                'total_orders' => $orders->total(),
                'orders' => $orders->items(),
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required'
        ]);

        $order_type = 'product';

        $user_id = auth('api')->user()->id ?? null;
        $db_cart_data = Cart::whereUserId($user_id)->get();
        if (empty($db_cart_data) || count($db_cart_data) == 0) {
            return response()->json(['status' => false, 'message' => "Please add atleast one product/equipment in cart to purchase."]);
        }

        if (empty(UserAddress::find($request->address_id))) {
            return response()->json(['status' => false, 'message' => "Please select valid address details."]);
        }

        if (!empty($request->input('promocode'))) {
            $applied_promocode = RedeemPromocode::whereStatus(0)->whereUserId($user_id)->where('promocode', $request->promocode)->first();
            if (empty($applied_promocode) || !isset($applied_promocode->id)) {
                $response = ['status' => false, 'message' => 'Invalid Promo Applied.', 'is_promocode_invalid' => true];
                return response()->json($response);
            }

            $db_promocode = Promocode::wherePromocode($request->promocode)->first();
            if (empty($db_promocode) || !isset($db_promocode->id) || $db_promocode->status == 0) {
                $response = ['status' => false, 'message' => 'Invalid Promo Applied.', 'is_promocode_invalid' => true];
                $applied_promocode->delete();
                return response()->json($response);
            }

            $promocode_start_date = Carbon::createFromFormat('Y-m-d H:i:s', $db_promocode->start_date, $this->app_settings['timezone'])->timezone('UTC')->format("Y-m-d H:i:s");
            $promocode_end_date = Carbon::createFromFormat('Y-m-d H:i:s', $db_promocode->end_date, $this->app_settings['timezone'])->timezone('UTC')->format("Y-m-d H:i:s");

            if (strtotime($promocode_start_date) > strtotime(date("Y-m-d H:i:s"))) {
                $response = ['status' => false, 'message' => 'Invalid Promo Applied.', 'is_promocode_invalid' => true];
                $applied_promocode->delete();
                return response()->json($response);
            }

            if (strtotime($promocode_end_date) < strtotime(date("Y-m-d H:i:s"))) {
                $response = ['status' => false, 'message' => 'Sorry, the promo code applied has expired.', 'is_promocode_invalid' => true];
                $applied_promocode->delete();
                return response()->json($response);
            }

            if ($db_promocode->used_limit > 0) {
                $user_promocodes = UserPromocode::where('promocode_id', $db_promocode->id)->count();
                if ($user_promocodes > 0) {
                    $user_promocodes = UserPromocode::wherePromocodeId($db_promocode->id)->whereUserId(auth('api')->user()->id)->count();
                    if ($user_promocodes == 0) {
                        $applied_promocode->delete();
                        $response = ['status' => false, 'message' => 'Invalid Promo Applied.', 'is_promocode_invalid' => true];
                        return response()->json($response);
                    }
                    $used_count = RedeemPromocode::whereUserId($user_id)->wherePromocode($db_promocode->promocode)->whereStatus(1)->count();
                    if ($used_count >= $db_promocode->used_limit) {
                        $applied_promocode->delete();
                        $response = ['status' => false, 'message' => 'Promocode maximum usage limit reached.', 'is_promocode_invalid' => true];
                        return response()->json($response);
                    }
                } else {
                    $used_count = RedeemPromocode::wherePromocode($db_promocode->promocode)->whereStatus(1)->count();
                    if ($used_count >= $db_promocode->used_limit) {
                        $applied_promocode->delete();
                        $response = ['status' => false, 'message' => 'Promocode used limit reached.', 'is_promocode_invalid' => true];
                        return response()->json($response);
                    }
                }
            }

            if($db_promocode->one_time_user > 0) {
                $used_count = RedeemPromocode::wherePromocode($db_promocode->promocode)->whereUserId($user_id)->whereStatus(1)->count();
                if($used_count > 0) {
                    $response = ['status' => false, 'message' => 'You have already used this promocode, Please try different promocode.', 'is_promocode_invalid' => true];
                        return response()->json($response);
                }
            }
        }

        $cart_total = 0;
        $reward_points = 0;
        $order_details = [];

        foreach ($db_cart_data as $db_cart) {
            $details = [];
            if (!empty($db_cart->subscription_id)) {
                if (empty($request->input('stripe_subscription_id'))) {
                    $request->validate([
                        'stripe_subscription_id' => 'required'
                    ]);
                }
                $details['stripe_subscription_id'] = $request->stripe_subscription_id;
                $details['subscription_id'] = $db_cart->subscription_id;
                $details['grind_id'] = $db_cart->grind_id;
                $price = $db_cart->subscription->price;
                $order_type = 'subscription';
            } else if (!empty($db_cart->equipment_id)) {
                $details['equipment_id'] = $db_cart->equipment_id;
                $price = $db_cart->equipment->price;
            } else if (!empty($db_cart->variant_id)) {
                $details['variant_id'] = $db_cart->variant_id;
                $details['product_id'] = $db_cart->product_id;
                $details['grind_id'] = $db_cart->grind_id;
                $price = $db_cart->variant->price;
                $reward_points = $reward_points + ($db_cart->variant->reward_point * $db_cart->quantity);
            } else {
                $details['product_id'] = $db_cart->product_id;
                $price = $db_cart->product->price;
                $reward_points = $reward_points + ($db_cart->variant->reward_point * $db_cart->quantity);
            }
            $db_cart->price = $price * $db_cart->quantity;
            $cart_total = $cart_total + ($price * $db_cart->quantity);

            $details['quantity'] = $db_cart->quantity;
            $details['amount'] = $price;
            $details['subtotal'] = $db_cart->price;
            $details['is_cancelled'] = $db_cart->is_cancelled;
            $order_details[] = $details;
        }

        $promocode_discount_amount = 0;
        $free_shipping_order = false;
        $promocode = RedeemPromocode::whereNull('order_id')->where('status', 0)->where('user_id', $user_id)->with('promocode_data')->first();
        if (!empty($promocode) && isset($promocode->id)) {
            if($promocode->type == 'free_shipping') {
                $free_shipping_order = true;
            }
            else {
                $promocode_discount_amount = $promocode->type == 'percentage' ? (($cart_total / 100) * $promocode->promocode_amount) : $promocode->promocode_amount;
            }
        }

        // not give point if promocode applied
        if (!empty($request->input('promocode'))) {
            $reward_points = 0;
        }

        $address = UserAddress::with(['city', 'country'])->find($request->address_id);
        $area_delivery_fee = $free_shipping_order === false ? ($address->city->delivery_fee ?? 0) : 0;
        $delivery_fee = (float) $area_delivery_fee; // ($this->app_settings['delivery_fee'] ?? 0);
        $subtotal = ($cart_total + $delivery_fee) - $promocode_discount_amount;

        $tax_charges = (float) ($this->app_settings['tax_charges'] ?? 0);
        if ($tax_charges > 0) {
            $tax_charges = ($subtotal / 100) * $tax_charges;
        }

        $payments = [
            'cart_total' => $cart_total ?? 0,
            'delivery_fee' => $delivery_fee,

            'promocode' => $promocode->promocode ?? null,
            'promocode_title' => $promocode->promocode_data->title ?? null,
            'promocode_discount_amount' => (float) $promocode_discount_amount ?? 0,

            'subtotal' => $subtotal ?? 0,
            'tax_charges' => $tax_charges,
            'total_amount' => $subtotal + $tax_charges,
            'payment_received' => 0,
            'balance' => ($subtotal + $tax_charges)
        ];

        $order_data = [
            'user_id' => $user_id,
            'address_id' => $request->address_id,
            'order_number' => time(),
            'order_type' => $order_type,

            'cart_total' => $payments['cart_total'],
            'delivery_fee' => $payments['delivery_fee'],

            'promocode' => $payments['promocode'],
            'promocode_amount' => $payments['promocode_discount_amount'],

            'subtotal' => $payments['subtotal'],

            'tax_charges' => $payments['tax_charges'],
            'total_amount' => $payments['total_amount'],
            'payable_amount' => $payments['total_amount'],

            'customer_note' => $request->customer_note ?? null,
            'reward_points' => $reward_points ?? 0,

            'payment_type' => isset($request->payment_type) && !empty($request->payment_type) ? $request->payment_type : 1,
            'card_number' => $request->card_number ?? null,
            'card_type' => ($request->payment_type == 2 ? strtolower($request->card_type) : null),
            'payment_status' => 1,
        ];

        $response = [
            'status' => true,
            'message' => 'Something went wrong, Please try again'
        ];

        $order = Order::create($order_data);
        if (!empty($order) && isset($order->id)) {
            foreach ($order_details as $detail) {
                $detail['order_id'] = $order->id;
                OrderDetail::create($detail);
                if (isset($detail['subscription_id']) && !empty($detail['subscription_id'])) {
                    UserSubscription::create([
                        'user_id' => $user_id,
                        'order_id' => $order->id,
                        'subscription_id' => $detail['subscription_id'],
                        'stripe_subscription_id' => $detail['stripe_subscription_id'],
                        'start_date' => date("Y-m-d H:i:s"),
                        'end_date' => date("Y-m-d H:i:s", strtotime("+30 days")),
                        'billing_date' => date("Y-m-d H:i:s"),
                        'subscription_status' => 1,
                    ]);
                }
            }

            if (!empty($reward_points) && $reward_points > 0) {
                UserReward::create([
                    'user_id' => auth('api')->id(),
                    'order_id' => $order->id,
                    'reward_type' => 'credit',
                    'reward_points' => $reward_points,
                ]);
            }

            $promocode = RedeemPromocode::whereNull('order_id')->where('status', 0)->where('promocode', $order->promocode)->first();
            if (!empty($promocode) && isset($promocode->id)) {
                $promocode->status = 1;
                $promocode->save();
            }

            $transaction_id = isset($request->transaction_id) && !empty($request->transaction_id) ? $request->transaction_id : null;
            $payment_amount = isset($request->payment_amount) && !empty($request->payment_amount) ? $request->payment_amount : null;
            if (!empty($transaction_id) && !empty($payment_amount)) {
                Transaction::create([
                    'order_id' => $order->id,
                    'payment_id' => $transaction_id,
                    'type' => 'card',
                    'payment_type' => 'payment',
                    'amount' => $payment_amount
                ]);
                $order->payment_received = $payment_amount;
                $order->payment_status = 2;
                $order->save();
            }

            $order = Order::whereUserId($user_id)
                ->with([
                    'user', 'address', 'details',
                    'details.product', 'details.variant', 'details.equipment', 'details.subscription',
                    'details.product.seller', 'details.equipment.seller',
                    'details.product.images', 'details.equipment.images'
                ])
                ->latest()
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
            } else {
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

            $response = [
                'status' => true,
                'message' => 'Order Successful',
                'order_id' => $order->id,
                'order' => $order
            ];
            Cart::whereUserId($user_id)->delete();

            try {
                Mail::to($order->user->email)->queue(new CustomerNewOrder($order));
                Mail::to(env('APP_ORDER_EMAIL', 'orders@sippyme.com'))->queue(new AppNewOrder($order));
            }
            catch(\Exception $e) {
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
                    } else {
                        $commission_fee = $detail->equipment->commission_fee * $detail->quantity;
                    }
                    $detail->seller_price = $detail->subtotal - $commission_fee;
                    $detail->commission_fee = $commission_fee;
                    $seller_details[$detail->equipment->seller->id][] = $detail;
                }
                if (!empty($detail->product_id)) {
                    $commission_fee = 0;
                    if ($detail->product->commission_type === 'percentage') {
                        $commission_fee = ($detail->subtotal / 100) * $detail->product->commission_fee;
                    } else {
                        $commission_fee = $detail->product->commission_fee * $detail->quantity;
                    }
                    $detail->seller_price = $detail->subtotal - $commission_fee;
                    $detail->commission_fee = $commission_fee;
                    $seller_details[$detail->product->seller->id][] = $detail;
                }
            }

            if (!empty($seller_details)) {
                foreach ($seller_details as $seller_id => $details) {
                    $seller = Seller::find($seller_id);
                    $order->seller_total = array_sum(array_column($details, "seller_price"));
                    $order->sippy_commission = array_sum(array_column($details, "commission_fee")) ?? 0;
                    Mail::to($seller->seller_email)->queue(new MerchantNewOrder($order, $details, $seller));
                }
            }
        }
        return response()->json($response);
    }
}
