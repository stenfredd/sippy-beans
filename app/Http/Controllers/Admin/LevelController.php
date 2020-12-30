<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $levels = Level::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($levels)
                ->addIndexColumn()
                ->addColumn('action', function ($level) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteLevel(this)" data-id="' . $level->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.levels');
    }

    public function save(Request $request) {
        $validation = [
            'level_title' => 'required',
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        if (isset($request_data['level_id']) && !empty($request_data['level_id'])) {
            $level = Level::find($request_data['level_id'])->update($request_data);
        }
        else {
            $level = Level::create($request_data);
        }

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($level) {
            $msg = isset($request_data['level_id']) && !empty($request_data['level_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Levels ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request) {
        $validation = [
            'level_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Level::destroy($request->level_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Level deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request) {
        $request->validate([
            'sorting_levels' => 'required'
        ]);

        $sorting_levels = json_decode($request->sorting_levels, true);
        foreach($sorting_levels as $levels) {
            Level::find($levels['level_id'])->update(['display_order' => $levels['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Cooffee type sorting order applied successfully.'];
        return response()->json($response);
    }
}
