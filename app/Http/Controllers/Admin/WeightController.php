<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Weight;
use Yajra\DataTables\Facades\DataTables;

class WeightController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $weights = Weight::select('*')->orderBy('id', 'desc')->get();

            return DataTables::of($weights)
                ->addIndexColumn()
                ->addColumn('action', function ($weight) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteWeight(this)" data-id="' . $weight->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        $page = new Weight;
        return view('admin.weight', compact('page'));
    }
    public function save(Request $request)
    {
        $validation = [
            'title' => 'required',
        ];
        $this->validate($request, $validation);
        $request_data = $request->all();
        if (isset($request_data['weight_id']) && !empty($request_data['weight_id'])) {
            $user = Weight::find($request_data['weight_id'])->update($request_data);
        } else {
            $user = Weight::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['weight_id']) && !empty($request_data['weight_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Weight ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }
    public function delete(Request $request)
    {
        $validation = [
            'weight_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Weight::destroy($request->weight_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Weight deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_weight' => 'required'
        ]);

        $sorting_weight = json_decode($request->sorting_weight, true);
        foreach ($sorting_weight as $weight) {
            Weight::find($weight['weight_id'])->update(['display_order' => $weight['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Weight sorting order applied successfully.'];
        return response()->json($response);
    }
}
