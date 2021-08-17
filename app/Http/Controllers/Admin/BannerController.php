<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::select('*')->orderBy('display_order', 'asc')->orderBy('id', 'desc');
        if ($request->ajax()) {
            if (!empty($request->input('search')) && !is_array($request->input('search'))) {
                $banners = $banners->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%" . $request->input('search') . "%");
                    $query->where('description', 'LIKE', "%" . $request->input('search') . "%");
                });
            }
            $banners = $banners->get();

            return DataTables::of($banners)
                ->addColumn('sort_image', function ($banner) {
                    return '<img src="' . asset('assets/images/sort-icon.png') . '" class="handle">';
                })
                ->editColumn('image_url', function ($banner) {
                    return '<img src="' . ($banner->image_url ? $banner->image_url : asset('images/logo/favicon.ico')) . '" class="handle" width="100" height="60"/>';
                })
                ->editColumn('url', function ($banner) {
                    return $banner->url ?? 'No';
                })
                ->editColumn('status', function ($banner) {
                    $status = '<div class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-center">
                    <input type="checkbox" class="custom-control-input" ' . ($banner->status == 1 ? 'checked' : '') . ' id="banner-status-' . $banner->id . '" onchange="updateStatus(' . $banner->id . ', ' . ($banner->status == 1 ? '0' : '1') . ')">
                    <label class="custom-control-label" for="banner-status-' . $banner->id . '">
                    <span class="switch-text-left"></span>
                    <span class="switch-text-right"></span>
                    </label>
                 </div>';
                    return $status;
                })
                ->editColumn('created_at', function ($banner) {
                    $date = $banner->created_at->timezone($this->app_settings['timezone'])->format("M d, Y");
                    return $date . ('<span class="d-block gray">' . $banner->created_at->timezone($this->app_settings["timezone"])->format("g:iA") . '</span>');
                })
                ->addColumn('action', function ($banner) {
                    return '<a href="' . url('admin/banners/' . $banner->id) . '" class="font-large-1"><i class="feather icon-eye"></i></a>';
                })
                ->rawColumns(['sort_image', 'image_url', 'status', 'created_at', 'action'])
                ->make(TRUE);
        }
        $banners = $banners->count();
        view()->share('page_title', 'Banners');
        return view('admin.banners.list', compact('banners'));
    }

    public function save(Request $request)
    {
        $validation = [
            'title' => 'required_if:status,null',
            'banner_id' => 'required_if:title,null',
        ];
        $this->validate($request, $validation);

        $request_data = $request->except('image_url');
        if ($request->hasFile('image_url')) {
            $image_file = $request->file('image_url');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/banners'), $imageName);
            $request_data['image_url'] = asset('uploads/banners/' . $imageName);
        }
        $request_data['status'] = isset($request_data['status']) ? $request_data['status'] : 0;
        if (isset($request_data['banner_id']) && !empty($request_data['banner_id'])) {
            $banner = Banner::find($request_data['banner_id'])->update($request_data);
            $banner_id = $request_data['banner_id'];
        } else {
            $banner = Banner::create($request_data);
            $banner_id = $banner->id;
        }
        if ($request->ajax()) {
            $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
            if ($banner) {
                $msg = isset($request_data['banner_id']) && !empty($request_data['banner_id']) ? 'updated' : 'created';
                $response = ['status' => true, 'message' => 'Banner ' . $msg . ' successfully.'];
            }
            return response()->json($response);
        } else {
            $msg = isset($request_data['banner_id']) && !empty($request_data['banner_id']) ? 'updated' : 'created';
            $msg1 = isset($request_data['banner_id']) && !empty($request_data['banner_id']) ? 'Updating' : 'Creating';
            if ($banner) {
                session()->flash('success', 'Banners ' . $msg . ' successfully.');
                return redirect(url('admin/banners/' . $banner_id));
            } else {
                session()->flash('error', $msg1 . ' category failed, Please try again.');
                return redirect()->back();
            }
        }
    }

    public function delete(Request $request)
    {
        $validation = [
            'banner_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Banner::destroy($request->banner_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Banner deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_banners' => 'required'
        ]);

        $sorting_banners = json_decode($request->sorting_banners, true);
        foreach ($sorting_banners as $banner) {
            Banner::find($banner['banner_id'])->update(['display_order' => $banner['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Banner sorting order applied successfully.'];
        return response()->json($response);
    }

    public function show($id = null)
    {
        $products = Product::whereStatus(1)->get();
        $equipments = Equipment::whereStatus(1)->get();

        $banner = Banner::find($id) ?? [];
        view()->share('page_title', 'Banner Details');
        return view('admin.banners.show', compact('banner', 'products', 'equipments'));
    }
}
