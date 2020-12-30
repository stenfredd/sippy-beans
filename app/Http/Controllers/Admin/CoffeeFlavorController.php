<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeFlavor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoffeeFlavorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $coffee_flavors = CoffeeFlavor::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($coffee_flavors)
                ->addIndexColumn()
                ->addColumn('action', function ($coffee_flavor) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteCoffeeFlavor(this)" data-id="' . $coffee_flavor->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.coffee_flavors');
    }

    public function save(Request $request)
    {
        $validation = [
            'flavor_name' => 'required',
        ];
        $this->validate($request, $validation);
        $request_data = $request->all();
        if (isset($request_data['coffee_flavor_id']) && !empty($request_data['coffee_flavor_id'])) {
            $coffee_flavor = CoffeeFlavor::find($request_data['coffee_flavor_id'])->update($request_data);
        } else {
            $coffee_flavor = CoffeeFlavor::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($coffee_flavor) {
            $msg = isset($request_data['coffee_flavor_id']) && !empty($request_data['coffee_flavor_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Coffee Flavor ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }
    public function delete(Request $request) {
        $validation = [
            'coffee_flavor_id' => 'required'
        ];
        $request->validate($validation);

        $delete = CoffeeFlavor::destroy($request->coffee_flavor_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Coffee Flavor deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request) {
        $request->validate([
            'sorting_coffee_flavors' => 'required'
        ]);

        $sorting_coffee_flavors = json_decode($request->sorting_coffee_flavors, true);
        foreach($sorting_coffee_flavors as $coffee_flavor) {
            CoffeeFlavor::find($coffee_flavor['coffee_flavor_id'])->update(['display_order' => $coffee_flavor['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Cooffee Flavor sorting order applied successfully.'];
        return response()->json($response);
    }
}
