<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function get(Request $request)
    {
        $page = $request->input('page') ?? 1;
        $search = $request->input('search') ?? "";
        $seller_id = $request->input('seller_id') ?? "";

        $limit = 20;
        $start = ($page - 1) * $limit;

        $equipments = Equipment::whereStatus(1)->latest();
        if (!empty($search)) {
            $equipments = $equipments->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
        if(!empty($seller_id)) {
            $equipments = $equipments->where('seller_id', $seller_id);
        }

        $total_equipments = $equipments->count();
        $equipments = $equipments->with('images')->offset($start)->limit($limit)->get();
        $totalPages = (ceil($total_equipments / $limit)) ?? 1;
        
        foreach($equipments as $equipment) {
            $equipment->available_quantity = $equipment->quantity ?? 0;
        }

        $response = [
            'status' => true,
            'totalPages' => $totalPages,
            'total_equipments' => $total_equipments,
            'equipments' => $equipments
        ];
        return response()->json($response);
    }
}
