<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::select('*')->with('country')->orderBy('id', 'desc')->get();

            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('country_name', function ($city) {
                    return $city->country->country_name ?? '-';
                })
                ->addColumn('action', function ($city) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteCity(this)" data-id="' . $city->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(TRUE);
        }
        $countries = Country::whereStatus(1)->get();
        return view('admin.cities', compact('countries'));
    }

    public function save(Request $request)
    {
        $validation = [
            'country_id' => 'required',
            'name' => 'required'
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();

        if (isset($request_data['city_id']) && !empty($request_data['city_id'])) {
            $user = City::find($request_data['city_id'])->update($request_data);
        } else {
            $user = City::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['city_id']) && !empty($request_data['city_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'City ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request) {
        $validation = [
            'city_id' => 'required'
        ];
        $request->validate($validation);

        $delete = City::destroy($request->city_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'City deleted successfully.'];
        }
        return response()->json($response);
    }
}
