<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use Yajra\DataTables\Facades\DataTables;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sellers = Seller::select('*')->orderBy('id', 'desc')->get();

            return DataTables::of($sellers)
                ->addIndexColumn()
                ->editColumn('seller_image', function ($seller) {
                    return '<img src="' . (!empty($seller->seller_image) ? asset($seller->seller_image) : asset('images/user-default.png')) . '" class="img-thumbnail" style="height: 100px; width: 100px;"/>';
                })
                ->addColumn('action', function ($seller) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteSeller(this)" data-id="' . $seller->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->rawColumns(['seller_image', 'action'])
                ->make(TRUE);
        }
        return view('admin.sellers');
    }

    public function save(Request $request)
    {
        $validation = [
            'seller_image' => 'required',
            'seller_name' => 'required',
            'seller_info' => 'required',
            'seller_address' => 'required',
            'seller_phone' => 'required|min:10|numeric',
            'seller_email' => 'required|email',
        ];
        $this->validate($request, $validation);

        $request_data = $request->except('seller_image');
        if ($file = $request->hasFile('seller_image')) {
            $file = $request->file('seller_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/sellers/';
            $file->move($destinationPath, $fileName);
            $request_data['seller_image'] = 'uploads/sellers/' . $fileName;
        }

        if (isset($request_data['seller_id']) && !empty($request_data['seller_id'])) {
            $user = Seller::find($request_data['seller_id'])->update($request_data);
        } else {
            $user = Seller::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['seller_id']) && !empty($request_data['seller_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Seller ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validation = [
            'seller_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Seller::destroy($request->seller_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Seller deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_sellers' => 'required'
        ]);

        $sorting_sellers = json_decode($request->sorting_sellers, true);
        foreach ($sorting_sellers as $seller) {
            Seller::find($seller['seller_id'])->update(['display_order' => $seller['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Seller sorting order applied successfully.'];
        return response()->json($response);
    }
}
