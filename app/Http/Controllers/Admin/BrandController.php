<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::select('*')->orderBy('id', 'desc')->get();

            return DataTables::of($brands)
                ->addIndexColumn()
                ->editColumn('brand_image', function ($brand) {
                    return '<img src="' . (asset($brand->brand_image) ? (asset($brand->brand_image)) : asset('images/logo/favicon.ico')) . '" class="img-thumbnail" style="height: 100px; width: 100px;"/>';
                })
                ->addColumn('action', function ($brand) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteBrand(this)" data-id="' . $brand->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->rawColumns(['brand_image', 'action'])
                ->make(TRUE);
        }
        return view('admin.brands');
    }

    public function save(Request $request)
    {
        $validation = [
            'brand_image' => 'required|image|mimes:jpg,png,jpeg',
            'name' => 'required',
            'short_description' => 'required',
            'description' => 'required'
        ];
        $this->validate($request, $validation);

        $request_data = $request->except('brand_image');

        if ($file = $request->hasFile('brand_image')) {
            $file = $request->file('brand_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/brands/';
            $file->move($destinationPath, $fileName);
            $request_data['brand_image'] = 'uploads/brands/' . $fileName;
        }

        if (isset($request_data['brand_id']) && !empty($request_data['brand_id'])) {
            $user = Brand::find($request_data['brand_id'])->update($request_data);
        } else {
            $user = Brand::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['brand_id']) && !empty($request_data['brand_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Brand ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validation = [
            'brand_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Brand::destroy($request->brand_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Brand deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_brands' => 'required'
        ]);

        $sorting_brands = json_decode($request->sorting_brands, true);
        foreach ($sorting_brands as $brand) {
            Brand::find($brand['brand_id'])->update(['display_order' => $brand['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Brand sorting order applied successfully.'];
        return response()->json($response);
    }
}
