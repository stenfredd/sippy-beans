<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use App\Models\RedeemPromocode;
use App\Models\UserPromocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'promocode' => 'required'
        ]);

        $user_id = auth('api')->user()->id;

        $promocode = Promocode::wherePromocode($request->promocode)->first();
        if (empty($promocode) || !isset($promocode->id) || $promocode->status == 0 || strtotime($promocode->start_date) > strtotime(date("Y-m-d H:i:s"))) {
            $response = ['status' => false, 'message' => 'Invalid promocode..!'];
            return response()->json($response);
        }

        if (strtotime($promocode->end_date) < strtotime(date("Y-m-d H:i:s"))) {
            $response = ['status' => false, 'message' => 'Promocode expired..!'];
            return response()->json($response);
        }

        if ($promocode->used_limit > 0) {
            $user_promocodes = UserPromocode::where('promocode_id', $promocode->id)->count();
            if ($user_promocodes > 0) {
                $user_promocodes = UserPromocode::wherePromocodeId($promocode->id)->whereUserId($promocode->id)->count();
                if ($user_promocodes == 0) {
                    $response = ['status' => false, 'message' => 'Invalid promocode..!'];
                    return response()->json($response);
                }
                $used_count = RedeemPromocode::whereUserId($user_id)->wherePromocodeId($promocode->id)->count();
                if ($used_count >= $promocode->used_limit) {
                    $response = ['status' => false, 'message' => 'Promocode used limit reached.'];
                    return response()->json($response);
                }
            } else {
                $used_count = RedeemPromocode::wherePromocode($promocode->promocode)->count();
                if ($used_count >= $promocode->used_limit) {
                    $response = ['status' => false, 'message' => 'Promocode used limit reached.'];
                    return response()->json($response);
                }
            }
        }

        RedeemPromocode::where('status', 0)->where('user_id', $user_id)->delete();
        $redeem_promocode = RedeemPromocode::create([
            'user_id' => $user_id,
            'request_id' => null,
            'promocode' => $promocode->promocode,
            'type' => $promocode->discount_type,
            'promocode_amount' => $promocode->discount_amount,
            'redeem_amount' => null,
            'status' => 0
        ]);
        if ($redeem_promocode) {
            return response()->json(['status' => true, 'message' => 'Promocode applied successfully.', 'promocode_id' => $redeem_promocode->id]);
        } else {
            return response()->json(['status' => false, 'message' => 'Applying promocode failed, Please try again.']);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'promocode_id' => 'required'
        ]);

        $promocode_id = $request->promocode_id;

        $remove = RedeemPromocode::destroy($promocode_id);
        if ($remove) {
            return response()->json(['status' => true, 'message' => 'Promocode removed successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Removing promocode failed, Please try again.']);
        }
    }
}
