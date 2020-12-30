<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use Yajra\DataTables\Facades\DataTables;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $types = Type::select('*')->orderBy('id', 'desc')->get();
            return DataTables::of($types)
                ->addIndexColumn()                
                ->editColumn('type_icon', function ($type) {
                    return '<img src="' . (asset($type->type_icon) ? (asset($type->type_icon)) : asset('images/logo/favicon.ico')) . '" class="img-thumbnail" style="height: 100px; width: 100px;"/>';
                })
                ->addColumn('action', function ($type) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteType(this)" data-id="' . $type->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->rawColumns(['type_icon', 'action'])
                ->make(TRUE);
        }
        return view('admin.type');
    }
    public function save(Request $request)
    {
        $validation = [           
            'title' => 'required',
            'description'=> 'required'
        ];
        $this->validate($request, $validation);
        $request_data = $request->all();
        if (isset($request_data['type_id']) && !empty($request_data['type_id'])) {
            $user = Type::find($request_data['type_id'])->update($request_data);
        } else {
            $user = Type::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['type_id']) && !empty($request_data['type_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Type ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }
    public function delete(Request $request) {
        $validation = [
            'type_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Type::destroy($request->type_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Type deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request) {
        $request->validate([
            'sorting_type' => 'required'
        ]);

        $sorting_type = json_decode($request->sorting_type, true);
        foreach($sorting_type as $type) {
            Type::find($type['type_id'])->update(['display_order' => $type['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Types sorting order applied successfully.'];
        return response()->json($response);
    }
}
