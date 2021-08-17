<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoffeeTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $coffee_types = CoffeeType::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($coffee_types)
                ->addIndexColumn()
                ->addColumn('action', function ($coffee_type) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteCoffeeType(this)" data-id="' . $coffee_type->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.coffee_types');
    }

    public function save(Request $request)
    {
        $validation = [
            'title' => 'required',
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        if (isset($request_data['coffee_type_id']) && !empty($request_data['coffee_type_id'])) {
            $coffee_type = CoffeeType::find($request_data['coffee_type_id'])->update($request_data);
        } else {
            $coffee_type = CoffeeType::create($request_data);
        }

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($coffee_type) {
            $msg = isset($request_data['coffee_type_id']) && !empty($request_data['coffee_type_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Coffee type ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validation = [
            'coffee_type_id' => 'required'
        ];
        $request->validate($validation);

        $delete = CoffeeType::destroy($request->coffee_type_id);

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Coffee type deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_coffee_type' => 'required'
        ]);

        $sorting_coffee_type = json_decode($request->sorting_coffee_type, true);
        foreach ($sorting_coffee_type as $coffee_type) {
            CoffeeType::find($coffee_type['coffee_type_id'])->update(['display_order' => $coffee_type['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Cooffee type sorting order applied successfully.'];
        return response()->json($response);
    }
}
