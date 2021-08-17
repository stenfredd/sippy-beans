<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BestFor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BestForController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $best_fors = BestFor::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($best_fors)
                ->addIndexColumn()
                ->addColumn('action', function ($best_for) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteBestFor(this)" data-id="' . $best_for->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.best_for');
    }

    public function save(Request $request)
    {
        $validation = [
            'title' => 'required',
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        if (isset($request_data['best_for_id']) && !empty($request_data['best_for_id'])) {
            $best_for = BestFor::find($request_data['best_for_id'])->update($request_data);
        } else {
            $best_for = BestFor::create($request_data);
        }

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($best_for) {
            $msg = isset($request_data['best_for_id']) && !empty($request_data['best_for_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Best For ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validation = [
            'best_for_id' => 'required'
        ];
        $request->validate($validation);

        $delete = BestFor::destroy($request->best_for_id);

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Best for deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_best_for' => 'required'
        ]);

        $sorting_best_for = json_decode($request->sorting_best_for, true);
        foreach ($sorting_best_for as $best_for) {
            BestFor::find($best_for['best_for_id'])->update(['display_order' => $best_for['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Best for sorting order applied successfully.'];
        return response()->json($response);
    }
}
