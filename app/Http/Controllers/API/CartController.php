<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\RedeemPromocode;
use App\Models\UserAddress;
use App\Models\OrderDetail;
use App\Models\Variant;
use App\Models\Equipment;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $db_cart_data = Cart::where('user_id', $user_id)->with(['variant', 'product', 'product.variants', 'product.images', 'equipment', 'equipment.images', 'subscription', 'product.weights'])->get();
        $response = [
            'status' => false,
            'message' => 'No cart data found.'
        ];

        if (!empty($db_cart_data) && count($db_cart_data) > 0) {
            $cart_total = 0;

            foreach ($db_cart_data as $db_cart) {
                $db_cart->brand_name = null;
                if (!empty($db_cart->subscription_id)) {
                    $db_cart->brand_name = 'SIPPY';
                    $price = $db_cart->subscription->price; // Quantity always 1
                } else if (!empty($db_cart->equipment_id)) {
                    $price = $db_cart->equipment->price * $db_cart->quantity;
                    $db_cart->equipment->available_quantity = $db_cart->equipment->quantity - (OrderDetail::whereEquipmentId($db_cart->equipment->id)->sum('quantity'));
                } else if (!empty($db_cart->variant)) {
                    $price = $db_cart->variant->price * $db_cart->quantity;                    
                    $db_cart->variant->available_quantity = $db_cart->variant->quantity - (OrderDetail::whereVariantId($db_cart->variant->id)->sum('quantity'));
                } else {
                    $price = $db_cart->product->price * $db_cart->quantity;
                }
                $db_cart->price = $price;
                $cart_total = $cart_total + $price;

                $db_cart->grind_title = $db_cart->grind->title ?? null;
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

            $address_id = null;
            $address = UserAddress::whereIsDefault(1)->whereUserId($user_id)->latest()->with('city')->with('country')->first();
            if (empty($address)) {
                $last_order = Order::whereUserId($user_id)->orderBy('id', 'desc')->first();
                if (!empty($last_order) && isset($last_order->id)) {
                    $address_id = $last_order->address_id;
                    $address = UserAddress::whereUserId($user_id)->latest()->with('city')->with('country')->find($address_id);
                }
            }
            if (empty($address)) {
                $address = UserAddress::whereUserId($user_id)->latest()->with('city')->with('country')->find($address_id);
            }

            $area_delivery_fee = 0;
            $area_delivery_time = '1-3 Business days';
            if (!empty($address) && isset($address->id)) {
                $address->city_name = $address->city->name ?? null;
                $address->country_name = $address->country->country_name ?? null;
                $area_delivery_fee = $free_shipping_order === false ? ($address->city->delivery_fee ?? 0) : 0;
                $area_delivery_time = $address->city->delivery_time ?? 0;
                unset($address->city);
                unset($address->country);
            }

            $tax_charges = ($this->app_settings['tax_charges'] ?? 0);
            $tax_charges = (($cart_total + ($area_delivery_fee ?? 0)) / 100 * $tax_charges);

            $payments = [
                'cart_total' => $cart_total ?? 0,
                'delivery_fee' => (float) ($area_delivery_fee ?? 0),
                'subtotal' => ($cart_total + ($area_delivery_fee ?? 0) - (float) $promocode_discount_amount) ?? 0,
                'promocode' => $promocode->promocode ?? null,
                'promocode_title' => $promocode->promocode_data->title ?? null,
                'promocode_discount_amount' => $promocode_discount_amount ?? 0,
                'tax_charges' => (float) $tax_charges,
                'payable_amount' => ($cart_total + ($area_delivery_fee ?? 0) + $tax_charges) - (float) $promocode_discount_amount,
                'payment_received' => 0,
                'balance' => ($cart_total + ($area_delivery_fee ?? 0) + $tax_charges) - (float) $promocode_discount_amount
            ];

            $payments['delivery_time'] = $area_delivery_time;
            $payments['allow_cash_payment'] = ($this->app_settings['allow_cash_payment'] == '1' ? true : false) ?? false;

            $response = [
                'status' => true,
                'cart_data' => $db_cart_data,
                'payments' => $payments,
                'address' => $address
            ];
        }
        return response()->json($response);
    }

    public function update(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required_if:equipment_id,null|required_if:product_id,null',
            'product_id' => 'required_if:equipment_id,null',
            'variant_id' => 'required_if:equipment_id,null',
            'grind_id' => 'required_if:equipment_id,null',
            'equipment_id' => 'required_if:product_id,null',
            'quantity' => 'required'
        ]);
        // info(print_r($request->all(), true));

        $user_id = auth('api')->user()->id;

        $cart = Cart::whereUserId(auth('api')->user()->id);

        if (!empty($request->input('subscription_id'))) {
            $cart = $cart->whereSubscriptionId($request->subscription_id);
            $request->quantity = 1;
        } else if (!empty($request->input('equipment_id'))) {
            $cart = $cart->whereEquipmentId($request->equipment_id);
        } else {
            $cart = $cart->whereProductId($request->product_id)->whereVariantId($request->variant_id)->whereGrindId($request->grind_id);
        }
        $cart = $cart->first();

        if (empty($cart) || !isset($cart->id)) {
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->product_id = $request->product_id ?? null;
            $cart->variant_id = $request->variant_id ?? null;
            $cart->equipment_id = $request->equipment_id ?? null;
            $cart->subscription_id = $request->subscription_id ?? null;
            $cart->grind_id = $request->grind_id ?? null;
            $cart->quantity = $request->quantity;
        } else {
            if (empty($request->input('subscription_id'))) {
                if (isset($request->type)) {
                    if ($request->type == 1) {
                        $cart->quantity = $cart->quantity + 1;
                    } else {
                        $cart->quantity = $cart->quantity - 1;
                    }
                } else {
                    $cart->quantity = $cart->quantity + $request->quantity;
                }
            }
        }

        if (!empty($request->input('equipment_id'))) {
            if($cart->quantity > (Equipment::find($request->equipment_id)->quantity - OrderDetail::whereEquipmentId($request->equipment_id)->sum('quantity'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Hi there, we’ve adjusted your order to the stock available at the moment. Not to worry, we’ll have enough next time.'
                ]);
            }
        }
        if (!empty($request->input('variant_id'))) {
            if($cart->quantity > (Variant::find($request->variant_id)->quantity - OrderDetail::whereVariantId($request->variant_id)->sum('quantity'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Hi there, we’ve adjusted your order to the stock available at the moment. Not to worry, we’ll have enough next time.'
                ]);
            }
        }

        if (!empty($request->input('subscription_id'))) {
            $cart->grind_id = $request->grind_id ?? null;
        }
        $status = $cart->save();

        $response = [
            'status' => false,
            'message' => 'Something went wrong, Please try again'
        ];
        if ($status) {
            $response = [
                'status' => true,
                'message' => 'Cart details saved successfully'
            ];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'cart_id' => 'required'
        ]);

        $status = false;
        if (isset($request->cart_id) && !empty($request->cart_id)) {
            $status = Cart::destroy($request->cart_id);
        }

        $cart_items = Cart::whereUserId(auth()->user()->id)->count();
        if ($cart_items == 0) {
            RedeemPromocode::where('status', 0)->where('user_id', auth()->user()->id)->delete();
        }

        $response = [
            'status' => $status ? true : false,
            'message' => $status ? 'Item removed from cart successfully.' : 'Removing item from cart failed, Please try again'
        ];
        return response()->json($response);
    }
}
