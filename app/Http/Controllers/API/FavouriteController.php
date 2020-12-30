<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function createUpdate(Request $request)
    {
        if(empty($request->input('product_id')) && empty($request->input('equipment_id'))) {
            $request->validate([
                'product_id' => 'required_unless:equipment_id,null',
                'equipment_id' => 'required_unless:product_id,null'
            ]);
        }

        $user_id = $request->user()->id ?? null;
        $product_id = $request->input('product_id') ?? null;
        $equipment_id = $request->input('equipment_id') ?? null;

        $db_favourite = Favourite::whereUserId($user_id);
        if(!empty($product_id)) {
            $db_favourite->whereProductId($product_id);
        }
        if(!empty($equipment_id)) {
            $db_favourite->whereEquipmentId($equipment_id);
        }
        $db_favourite = $db_favourite->first();
        if(!empty($db_favourite) && isset($db_favourite->id)) {
            $db_favourite->delete();
            $response = ['status' => true, 'message' => 'Removed from favourite successfully.'];
        }
        else {
            Favourite::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'equipment_id' => $equipment_id,
            ]);
            $response = ['status' => true, 'message' => 'Added to favourite list successfully.'];
        }

        return response()->json($response);
    }

    public function get(Request $request)
    {
        $page = $request->input('page') ?? 1;

        $limit = 20;
        $start = ($page - 1) * $limit;

        $favourites = Favourite::latest()->with(['product', 'equipment']);

        $total_favourites = $favourites->count();
        $favourites = $favourites->offset($start)->limit($limit)->get();
        $total_pages = (ceil($total_favourites / $limit)) ?? 1;

        $response = [
            'status' => true,
            'total_pages' => $total_pages,
            'total_favourites' => $total_favourites,
            'favourites' => $favourites
        ];
        return response()->json($response);
    }
}
