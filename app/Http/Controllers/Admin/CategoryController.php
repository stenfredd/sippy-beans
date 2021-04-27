<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select('*');
            if (!empty($request->input('search')) && !is_array($request->input('search'))) {
                $categories = $categories->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('description', 'LIKE', "%" . $request->input('search') . "%");
                });
            }
            $categories = $categories->orderBy('display_order', 'asc')->get();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('image_url', function ($category) {
                    return '<img src="' . (asset($category->image_url) ? (asset($category->image_url)) : asset('images/logo/favicon.ico')) . '" class="img-thumbnail" style="height: 100px; width: 100px;"/>';
                })
                ->addColumn('sort_image', function ($category) {
                    return '<img src="' . asset('assets/images/sort-icon.png') . '" class="handle">';
                })
                ->addColumn('title_desc', function ($category) {
                    $category_title = '<p class="font-small-3 text-bold-700 mb-0">' . $category->category_title . '</p>
                                    <span class="font-small-3 text-bold-500 ">' . $category->description . '</span>';
                    return $category_title;
                })
                ->addColumn('products_count', function ($category) {
                    $pro_cnt = Product::whereRaw('FIND_IN_SET("'.$category->id.'", category_id)')->count();
                    if ($pro_cnt == 0) {
                        $pro_cnt = Equipment::whereRaw('FIND_IN_SET("'.$category->id.'", category_id)')->count();
                    }
                    return $pro_cnt;
                })
                ->addColumn('status', function ($category) {
                    $action = '<div
                                class="custom-control custom-switch custom-switch-success mr-2 mb-1 text-center">
                                <input type="checkbox" class="custom-control-input" ' . ($category->status == 1 ? 'checked' : '') . ' id="status-' . $category->id . '" onchange="updateStatus(' . $category->id . ', ' . ($category->status == 1 ? '0' : '1') . ')">
                                <label class="custom-control-label" for="status-' . $category->id . '">
                                    <span class="switch-text-left"></span>
                                    <span class="switch-text-right"></span>
                                </label>
                            </div>';
                    return $action;
                })
                ->addColumn('action', function ($category) {
                    $action = '<a href="' . url('admin/categories/' . $category->id) . '">
                            <img src="' . asset('assets/images/extra-icon-orange.svg') . '" width="7">
                                    </a>';
                    return $action;
                })
                ->rawColumns(['sort_image', 'image_url', 'title_desc', 'status',  'action'])
                ->make(TRUE);
        }
        $total_categories = Category::count();
        view()->share('page_title', 'Categories');
        return view('admin.categories.list', compact('total_categories'));
    }

    public function show(Request $request, $id = null)
    {
        $category = Category::find($id);
        $products = Product::whereRaw('FIND_IN_SET("'.$id.'", category_id)')->count();
        $is_equipment = 0;
        if ($products == 0) {
            $products = Equipment::whereRaw('FIND_IN_SET("'.$id.'", category_id)')->count();
            $is_equipment = 1;
        }
//        $dbProducts = Product::leftJoin('product_categories', 'products.id', 'product_categories.product_id')->orderBy('product_categories.display_order')->get();
//        $dbEquipments = Product::leftJoin('product_categories', 'products.id', 'product_categories.product_id')->orderBy('product_categories.display_order')->get();
        view()->share('page_title', (!empty($id) && is_numeric($id) ? 'Update Category' : 'Add New Category'));
        return view('admin.categories.show', compact('category', 'products', 'is_equipment'));
    }

    public function save(Request $request)
    {
        $validation = [
            'title' => 'required_if:category_id,null',
            'description' => 'required_if:category_id,null'
        ];
        $this->validate($request, $validation);
        $request_data = $request->except('image_url');
        $request_data = array_filter($request_data);
        if ($request->hasFile('image_url')) {
            $image_file = $request->file('image_url');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/categories'), $imageName);
            $request_data['image_url'] = asset('uploads/categories/' . $imageName);
        }
        $request_data['status'] = isset($request_data['status']) ? $request_data['status'] : 0;
        if (isset($request_data['category_id']) && !empty($request_data['category_id'])) {
            $category = Category::find($request_data['category_id'])->update($request_data);
        } else {
            $category = Category::create($request_data);
        }
        if ($request->ajax()) {
            $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
            if ($category) {
                $msg = isset($request_data['category_id']) && !empty($request_data['category_id']) ? 'updated' : 'created';
                $response = ['status' => true, 'message' => 'Category ' . $msg . ' successfully.'];
            }
            return response()->json($response);
        } else {
            $msg = isset($request_data['category_id']) && !empty($request_data['category_id']) ? 'updated' : 'created';
            $msg1 = isset($request_data['category_id']) && !empty($request_data['category_id']) ? 'Updating' : 'Creating';
            if ($category) {
                session()->flash('success', 'Category ' . $msg . ' successfully.');
                return redirect(url('admin/categories/' . ($request->category_id ?? $category->id)));
            } else {
                session()->flash('error', $msg1 . ' category failed, Please try again.');
                return redirect()->back();
            }
        }
    }

    public function delete(Request $request)
    {
        $validation = [
            'category_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Category::destroy($request->category_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Category deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_categories' => 'required'
        ]);

        $sorting_categories = json_decode($request->sorting_categories, true);
        // dd($sorting_categories);
        foreach ($sorting_categories as $category) {
            Category::find($category['category_id'])->update(['display_order' => $category['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Categories sorting order applied successfully.'];
        return response()->json($response);
    }

    public function updateProductsSortOrders(Request $request)
    {
        $request->validate([
            'sorting_products' => 'required'
        ]);

        $is_equipment = $request->is_equipment ?? 0;
        $category_id = $request->post('category_id');

        $sorting_products = json_decode($request->sorting_products, true);
        foreach ($sorting_products as $product) {
            if (isset($is_equipment) && $is_equipment == 1) {
                // Equipment::find($product['product_id'])->update(['display_order' => $product['sort_order']]);
                ProductCategory::updateOrCreate(
                    ['equipment_id' => $product['product_id'], 'category_id' => $category_id],
                    ['equipment_id' => $product['product_id'], 'category_id' => $category_id, 'display_order' => $product['sort_order']]
                );
            } else {
                // Product::find($product['product_id'])->update(['display_order' => $product['sort_order']]);
                ProductCategory::updateOrCreate(
                    ['product_id' => $product['product_id'], 'category_id' => $category_id],
                    ['product_id' => $product['product_id'], 'category_id' => $category_id, 'display_order' => $product['sort_order']]
                );
            }
        }
        $response = ['status' => true, 'message' => 'Product sorting order applied successfully.'];
        return response()->json($response);
    }

    public function removeProduct(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        $id = $request->id ?? 0;
        $is_equipment = $request->is_equipment ?? 0;

        if (isset($is_equipment) && $is_equipment == 1) {
            Equipment::find($id)->update(['category_id' => null]);
        } else {
            Product::find($id)->update(['category_id' => null]);
        }

        $response = ['status' => true, 'message' => 'Product removed from category successfully.'];
        return response()->json($response);
    }
}
