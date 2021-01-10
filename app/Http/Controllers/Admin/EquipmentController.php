<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Seller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CoffeeType;
use App\Models\Image;
use Yajra\DataTables\Facades\DataTables;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $equipments = Equipment::select('*')->whereStatus(1);
        if ($request->ajax()) {
            if (!empty($request->input('search')) && !is_array($request->input('search'))) {
                $equipments = $equipments->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('short_description', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('description', 'LIKE', "%" . $request->input('search') . "%");
                });
            }
            $equipments = $equipments->with("images")->orderBy('display_order', 'asc')->get();

            return DataTables::of($equipments)
                ->addIndexColumn()
                ->addColumn('sort_image', function ($banner) {
                    return '<img src="' . asset('assets/images/sort-icon.png') . '" class="handle">';
                })
                ->addColumn('image_path', function ($equipment) {
                    $image_url = $equipment->images[0]->image_path ?? null;
                    return '<img src="' . asset($image_url ?? 'assets/images/product-img.png') . '">';
                })
                ->addColumn('product_name', function ($equipment) {
                    return $equipment->title ?? '-';
                })
                ->addColumn('brand_name', function ($equipment) {
                    return $equipment->brand->name ?? '-';
                })
                ->addColumn('seller_name', function ($equipment) {
                    return $equipment->seller->seller_name ?? '-';
                })
                ->editColumn('created_at', function ($banner) {
                    $date = $banner->created_at->timezone($this->app_settings['timezone'])->format("M d, Y");
                    return $date . ('<span class="d-block gray">' . $banner->created_at->timezone($this->app_settings["timezone"])->format("g:iA") . '</span>');
                })
                ->addColumn('action', function ($equipment) use ($request) {
                    $action = '<a href="' . url('admin/equipments/' . $equipment->id) . '"><i class="feather icon-eye"></i></a>';
                if (isset($request->category_id) && !empty($request->category_id)) {
                    $action .= '<a class="ml-1" href="javascript:" onclick="removeProduct(' . $equipment->id . ')"><i class="feather icon-trash"></i></a>';
                }
                    return $action;
                })
                ->editColumn('status', function ($equipment) {
                    return ($equipment->status == 1 ? 'Enabled' : 'Disabled');
                })
                ->editColumn('price', function ($equipment) {
                    return $this->app_settings['currency_code'] . ' ' . number_format($equipment->price, 2);
                })
                ->rawColumns(['sort_image', 'chk_select', 'image_path', 'created_at', 'action'])
                ->make(TRUE);
        }
        $total_equipments = $equipments->count();
        view()->share('page_title', 'Equipments');
        return view('admin.equipments.list', compact('total_equipments'));
    }

    public function save(Request $request)
    {
        $validation = [
            // 'status' => 'required',
            'title' => 'required',
            'short_description' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'brand_id' => 'required',
            'seller_id' => 'required',
            'description' => 'required',
            // 'tags' => 'required'
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        $request_data['status'] = isset($request_data['status']) ? $request_data['status'] : 0;
        if (isset($request_data['equipment_id']) && !empty($request_data['equipment_id'])) {
            $equipment = Equipment::find($request_data['equipment_id'])->update($request_data);
            $equipment_id = $request_data['equipment_id'];
        } else {
            $equipment = Equipment::create($request_data);
            $equipment_id = $equipment->id;
        }

        if ($request->hasFile('image_0')) {
            $image_file = $request->file('image_0');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/equipments'), $imageName);
            $img = Image::whereType('equipment')->whereContentId($equipment_id)->whereDisplayOrder(1)->first();
            if(empty($img) || !isset($img->id)) {
                $img = new Image();
                $img->type = 'equipment';
                $img->content_id = $equipment_id;
                $img->display_order = 1;
            }
            $img->image_path = 'uploads/equipments/' . $imageName;
            $img->save();
            // Image::whereType('equipment')->whereContentId($equipment_id)->whereDisplayOrder(1)->update(['image_path' => 'uploads/equipments/' . $imageName]);
        }
        if ($request->hasFile('image_1')) {
            $image_file = $request->file('image_1');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/equipments'), $imageName);
            // Image::whereType('equipment')->whereContentId($equipment_id)->whereDisplayOrder(2)->update(['image_path' => 'uploads/equipments/' . $imageName]);
            $img = Image::whereType('equipment')->whereContentId($equipment_id)->whereDisplayOrder(2)->first();
            if (empty($img) || !isset($img->id)) {
                $img = new Image();
                $img->type = 'equipment';
                $img->content_id = $equipment_id;
                $img->display_order = 2;
            }
            $img->image_path = 'uploads/equipments/' . $imageName;
            $img->save();
        }
        if ($request->hasFile('image_2')) {
            $image_file = $request->file('image_2');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/equipments'), $imageName);
            // Image::whereType('equipment')->whereContentId($equipment_id)->whereDisplayOrder(3)->update(['image_path' => 'uploads/equipments/' . $imageName]);
            $img = Image::whereType('equipment')->whereContentId($equipment_id)->whereDisplayOrder(3)->first();
            if (empty($img) || !isset($img->id)) {
                $img = new Image();
                $img->type = 'equipment';
                $img->content_id = $equipment_id;
                $img->display_order = 3;
            }
            $img->image_path = 'uploads/equipments/' . $imageName;
            $img->save();
        }

        $msg = isset($request_data['equipment_id']) && !empty($request_data['equipment_id']) ? 'updated' : 'created';
        $msg1 = isset($request_data['equipment_id']) && !empty($request_data['equipment_id']) ? 'Updating' : 'Creating';
        if ($equipment) {
            session()->flash('success', 'Equipment details ' . $msg . ' successfully.');
            return redirect(url('admin/equipments/' . $equipment_id));
        } else {
            session()->flash('error', $msg1 . ' equipment details failed, Please try again.');
            return redirect()->back();
        }
    }
    public function delete(Request $request)
    {
        $validation = [
            'equipment_id' => 'required'
        ];
        $request->validate($validation);

        $image = Image::where('content_id', $request->equipment_id)->first();
        if ($image) {
            $image->delete();
        }
        // $img=Image::select('*')->where('content_id', '=',$request->equipment_id)->get();
        // if($request->equipment_id == $img[0]['content_id']){
        //     $imageDelete = Image::destroy($img[0]['id']);
        // }
        $delete = Equipment::destroy($request->equipment_id);

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Equipment deleted successfully.'];
        }
        return response()->json($response);
    }

    public function show(Request $request, $id = null)
    {
        $equipment = Equipment::with('images')->find($id);
        $brands = Brand::whereStatus(1)->get();
        $sellers = Seller::whereStatus(1)->get();
        $coffeeTypes = CoffeeType::whereStatus(1)->orderBy('display_order', 'asc')->get();
        $categories = Category::whereStatus(1)->get();

        view()->share('page_title', (!empty($id) && is_numeric($id) ? 'Update Equipment' : 'Add New Equipment'));
        return view('admin.equipments.show', compact('equipment', 'brands', 'sellers', 'coffeeTypes', 'categories'));
    }
}
