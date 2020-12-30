<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MatchMakers;
use App\Models\UserMatchMaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchMakerController extends Controller
{
    public function index(Request $request)
    {
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];

        $user_id = auth('api')->user()->id;

        $match_makers = MatchMakers::select('match_makers.*', 'user_match_makers.values')
                    ->leftJoin('user_match_makers', function ($q) use($user_id) {
                        $q->on('match_makers.id', 'user_match_makers.match_maker_id');
                        $q->where('user_id', $user_id);
                    })
                    ->where('match_makers.status', 1)
                    ->orderBy("match_makers.id")
                    ->get();

        $fields = [
            'best_for' => 'id,title',
            'brand' => 'id,name as title',
            'characteristic' => 'id,title',
            'coffee_flavor' => 'id,flavor_name as title',
            'grind' => 'id,title',
            'level' => 'id,level_title as title',
            'origin' => 'id,origin_name as title',
            'process' => 'id,title',
            'seller' => 'id,seller_name as title',
            'type' => 'id,title',
            'price' => 'id,title,min_price,max_price',
            'coffee_type' => 'id,title',
        ];

        if (!empty($match_makers)  && count($match_makers) > 0) {
            foreach($match_makers as $match_maker) {
                $match_maker->options = [];
                if(!empty($match_maker->type)) {
                    $match_maker->options = DB::table($match_maker->type .($match_maker->type == 'process' ? 'e' : '') . 's')->selectRaw($fields[$match_maker->type])->get();
                }

                $match_maker->values = explode(',', $match_maker->values);
                if(!empty($match_maker->options) && count($match_maker->options) > 0) {
                    foreach($match_maker->options as $option) {
                        $option->is_selected = (in_array($option->id, $match_maker->values) ? 1 : 0);
                    }
                }
            }
            $response = ['status' => true, 'data' => $match_makers];
        }

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $request->validate([
            'match_maker_obj' => 'required',
            // 'values' => 'required'
        ]);
        $save = false;
        // $request->match_maker_obj = trim($request->match_maker_obj, '"');
        $match_maker_obj = json_decode($request->match_maker_obj, true);
        $user_id = auth('api')->user()->id;
        foreach($match_maker_obj as $match_maker) {
            $user_match_maker = UserMatchMaker::where('user_id', $user_id)->where('match_maker_id', $match_maker['id'])->first();
            if(empty($user_match_maker) || !isset($user_match_maker->id)) {
                $user_match_maker = new UserMatchMaker();
                $user_match_maker->user_id = $user_id;
                $user_match_maker->match_maker_id = $match_maker['id'];
            }
            $user_match_maker->values = $match_maker['values'];
            $save = $user_match_maker->save();
        }

        if($save)
        {
            return response()->json(['status' => true, 'message' => 'Match makers details updated succesfully.']);
        }
        return response()->json(['status' => true, 'message' => 'Something went wrong, Please try again.']);
    }
}
