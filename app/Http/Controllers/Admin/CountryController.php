<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Country::select('*')->orderBy('id', 'desc')->get();

            return DataTables::of($countries)
                ->addIndexColumn()
                ->addColumn('action', function ($country) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteCountry(this)" data-id="' . $country->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(TRUE);
        }
        return view('admin.countries');
    }

    public function save(Request $request)
    {
        $validation = [
            'country_name' => 'required'
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        if (isset($request_data['country_id']) && !empty($request_data['country_id'])) {
            $user = Country::find($request_data['country_id'])->update($request_data);
        } else {
            $user = Country::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['country_id']) && !empty($request_data['country_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Country ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validation = [
            'country_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Country::destroy($request->country_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Country deleted successfully.'];
        }
        return response()->json($response);
    }
}
