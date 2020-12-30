<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Origin;
use Yajra\DataTables\Facades\DataTables;

class OriginController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $origins = Origin::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($origins)
                ->addIndexColumn()
                ->addColumn('action', function ($origin) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteOrigin(this)" data-id="' . $origin->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.origins');
    }
    public function save(Request $request) {
        $validation = [
            'origin_name' => 'required',
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        if (isset($request_data['origin_id']) && !empty($request_data['origin_id'])) {
            $origin = Origin::find($request_data['origin_id'])->update($request_data);
        } else {
            $origin = Origin::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($origin) {
            $msg = isset($request_data['origin_id']) && !empty($request_data['origin_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Origins ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request) {
        $validation = [
            'origin_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Origin::destroy($request->origin_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Origin deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request) {
        $request->validate([
            'sorting_origins' => 'required'
        ]);

        $sorting_origins = json_decode($request->sorting_origins, true);
        foreach($sorting_origins as $origins) {
            Origin::find($origins['origin_id'])->update(['display_order' => $origins['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Origins sorting order applied successfully.'];
        return response()->json($response);
    }
}
