<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grind;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GrindController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $grinds = Grind::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($grinds)
                ->addIndexColumn()
                ->addColumn('action', function ($girnd) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteGrind(this)" data-id="' . $girnd->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.grinds');
    }

    public function save(Request $request)
    {
        $validation = [
            'title' => 'required',
        ];
        $this->validate($request, $validation);
        $request_data = $request->all();
        if (isset($request_data['grind_id']) && !empty($request_data['grind_id'])) {
            $grind = Grind::find($request_data['grind_id'])->update($request_data);
        } else {
            $grind = Grind::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($grind) {
            $msg = isset($request_data['grind_id']) && !empty($request_data['grind_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => ' Grind ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }
    public function delete(Request $request) {
        $validation = [
            'grind_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Grind::destroy($request->grind_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Grind  deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request) {
        $request->validate([
            'sorting_grinds' => 'required'
        ]);

        $sorting_grinds = json_decode($request->sorting_grinds, true);
        foreach($sorting_grinds as $grind) {
            Grind::find($grind['grind_id'])->update(['display_order' => $grind['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Grind sorting order applied successfully.'];
        return response()->json($response);
    }
}
