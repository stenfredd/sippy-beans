<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Grind;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscription = Subscription::first();
        $subscription->brand_name = "SIPPY";
        $subscription->title = strtoupper($subscription->title);
        $grinds = Grind::whereGrindType(1)->get();
        $user_subscription = UserSubscription::whereUserId(auth('api')->user()->id ?? 0)->whereSubscriptionStatus(1)->first();

        $cart_data = Cart::whereUserId(auth('api')->user()->id ?? 0)->whereSubscriptionId($subscription->id);

        $cart_subscription = $cart_data->count();
        $cart_status = $cart_subscription > 0 ? true : false;

        $cart_subscription = $cart_data->first();

        if ($cart_status === true) {
            $cart_subscription->grind_title = Grind::find($cart_subscription->grind_id)->title ?? null;
        }

        return response()->json(['status' => true, 'data' => $subscription, 'grinds' => $grinds, 'user_subscription' => $user_subscription, 'cart_status' => $cart_status, 'cart_subscription' => $cart_subscription]);
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'user_subscription_id' => 'required'
        ]);

        $save = false;
        $user_subscription = UserSubscription::find($request->user_subscription_id);
        if (!empty($user_subscription) && isset($user_subscription->id)) {
            $user_subscription->cancelled_at = date("Y-m-d H:i:s");
            $save = $user_subscription->save();
        }

        if ($save) {
            try {
                $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
                $stripe->subscriptions->cancel(
                    $user_subscription->stripe_subscription_id,
                    []
                );
            } catch (\Exception $e) {
                info("Subscription cancel error - " . $e->getMessage());
            }
            return response()->json(['status' => true, 'message' => 'Subscription cancelled successfully.']);
        }
        return response()->json(['status' => false, 'message' => 'Something went wrong, Please try again.']);
    }
}
