<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Origin;
use App\Models\Brand;
use App\Models\BestFor;
use App\Models\Category;
use App\Models\Type;
use App\Models\Level;
use App\Models\Image;
use App\Models\Process;
use App\Models\Grind;
use App\Models\Characteristic;
use App\Models\CoffeeType;
use App\Models\Weight;
use App\Models\Variant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::select('*')->whereStatus(1);
        if ($request->ajax()) {
            if (!empty($request->input('search')) && !is_array($request->input('search'))) {
                $products = $products->where(function ($query) use ($request) {
                    $query->where('product_name', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('varietal', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('altitude', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('flavor_note', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('description', 'LIKE', "%" . $request->input('search') . "%");
                });
            }
            if(!empty($request->input('category_id'))) {
                $products = $products->whereCategoryId($request->category_id);
            }
            $products = $products->with("images")->orderBy('id')->get();

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('image_path', function ($product) {
                    $image_url = $product->images[0]->image_path ?? null;
                    return '<img src="' . asset($image_url ?? 'assets/images/product-img.png') . '">';
                })
                ->addColumn('brand_name', function ($product) {
                    return $product->brand->name ?? '-';
                })
                ->addColumn('seller_name', function ($product) {
                    return $product->seller->seller_name ?? '-';
                })
                ->editColumn('created_at', function ($banner) {
                    $date = $banner->created_at->timezone($this->app_settings['timezone'])->format("M d, Y");
                    return $date . ('<span class="d-block gray">' . $banner->created_at->timezone($this->app_settings["timezone"])->format("g:iA") . '</span>');
                })
                ->addColumn('action', function ($product) {
                    $action = '<a href="' . url('admin/products/' . $product->id) . '"><i class="feather icon-eye"></i></a>';
                    return $action;
                })
                ->editColumn('status', function($product) {
                    return ($product->status == 1 ? 'Enabled' : 'Disabled');
                })
                ->rawColumns(['chk_select', 'image_path', 'created_at', 'action'])
                ->make(TRUE);
        }
        $total_products = $products->count();
        view()->share('page_title', 'Beans');
        return view('admin.products.list', compact('total_products'));
    }

    public function show(Request $request, $id = null)
    {
        $product = Product::with('variants')->find($id);
        $variants = [];
        if(!empty($product) && isset($product->id)) {
            foreach($product->variants as $variant) {
                $grind_ids = explode(',', $variant->grind_ids);
                foreach($grind_ids as $grind_id) {
                    $variant_grind = $variant->replicate();
                    $variant_grind->id = $variant->id;
                    $variant_grind->grind_id = $grind_id;
                    $variant_grind->grind_title = Grind::find($grind_id)->title ?? '';
                    $variants[] = $variant_grind;
                }
            }
            $product->variants = $variants;
        }

        $brands = Brand::whereStatus(1)->orderBy('display_order', 'asc')->get();
        // $types = Type::whereStatus(1)->orderBy('display_order', 'asc')->get();
        // $sellers = Seller::whereStatus(1)->orderBy('display_order', 'asc')->get();
        $sellers = Seller::whereStatus(1)->get();

        $origins = Origin::whereStatus(1)->get();
        $characteristics = Characteristic::whereStatus(1)->get();
        $bestFor = BestFor::whereStatus(1)->orderBy('display_order', 'asc')->get();
        $levels = Level::whereStatus(1)->orderBy('display_order', 'asc')->get();
        $processes = Process::whereStatus(1)->orderBy('display_order', 'asc')->get();
        $types = Type::whereStatus(1)->orderBy('display_order', 'asc')->get();

        $coffeeTypes = CoffeeType::whereStatus(1)->orderBy('display_order', 'asc')->get();
        $grinds = Grind::whereStatus(1)->get();
        // $tax_classes = TaxClass::whereStatus(1)->get();
        $weights = Weight::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();

        view()->share('page_title', (!empty($id) && is_numeric($id) ? 'Update Product' : 'Add New Product'));
        return view('admin.products.show', compact('product', 'brands', 'types', 'sellers', 'origins', 'characteristics', 'bestFor', 'levels', 'processes', 'types', 'weights', 'grinds', 'coffeeTypes', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|max:150',
            'description' => 'required',
            'varietal' => 'required',
            'altitude' => 'required',
            'sku' => 'required',
            // 'reward_point' => 'required',
            'quantity' => 'required',
            'flavor_note' => 'required',
            'type_id' => 'required',
            'origin_id' => 'required',
            'brand_id' => 'required',
            'brand_type_id' => 'required',
            'characteristic_id' => 'required',
            'best_for_id' => 'required',
            'coffee_type_id' => 'required',
            'level_id' => 'required',
            'process_id' => 'required',
            'seller_id' => 'required',
            // 'tax_class_id' => 'required',
        ]);

        $data = $request->except(['grind_id', 'weight_id']);
        $data['status'] = isset($data['status']) && $data['status'] == 'on' ? 1 : 0;
        if (isset($data['id'])) {
            $product = Product::find($data['id']);
            $product->save();
            $product = $product->fresh();
        } else {
            $product = Product::create($data);
        }

        if ($product) {
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                Image::whereContentId($product->id)->whereType('product')->delete();
                foreach ($files as $file) {
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/products/' . $product->id);
                    $file->move($destinationPath, $fileName);
                    Image::create([
                        'type' => 'product',
                        'content_id' => $product->id,
                        'image_path' => 'uploads/products/' . $fileName,
                        'status' => 1,
                    ]);
                }
            }

            if (!empty($request->input('grind_id')) && !empty($request->input('weight_id'))) {
                foreach ($request->input('grind_id') as $key => $grind_id) {
                    Variant::whereProductId($product->id)->whereGrindId($grind_id)->delete();
                    foreach ($request->input('weight_id') as $weight_id) {
                        Variant::create([
                            'product_id' => $product->id,
                            'grind_id' => $grind_id,
                            'weight_id' => $weight_id,
                            'price' => 50,
                            'quantity' => $request->quantity ?? 100,
                            'is_default' => ($key == 0 ? 1 : 0),
                            'status' => 1
                        ]);
                    }
                }
            }
        }

        return redirect('admin/products');
    }

    public function save(Request $request)
    {
        $validation = [
            // 'status' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'brand_id' => 'required',
            'type_id' => 'required',
            'seller_id' => 'required',
            'origin_id' => 'required',
            'varietal' => 'required',
            'flavor_note' => 'required',
            'characteristic_id' => 'required',
            'best_for_id' => 'required',
            'level_id' => 'required',
            'altitude' => 'required',
            'process_id' => 'required',
            'tags' => 'required'
        ];
        $this->validate($request, $validation);

        $request_data = $request->except(['image_0', 'image_1', 'image_2']);
        /* if ($request->hasFile('image_url')) {
            $image_file = $request->file('image_url');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/subscriptions'), $imageName);
            $request_data['image_url'] = asset('uploads/subscriptions/' . $imageName);
        } */
        $request_data['status'] = isset($request_data['status']) ? $request_data['status'] : 0;
        if (isset($request_data['product_id']) && !empty($request_data['product_id'])) {
            $product = Product::find($request_data['product_id'])->update($request_data);
            $product_id = $request_data['product_id'];
        } else {
            $product = Product::create($request_data);
            $product_id = $product->id;
        }


        if ($request->hasFile('image_0')) {
            $image_file = $request->file('image_0');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/products'), $imageName);
            Image::whereType('product')->whereContentId($product_id)->whereDisplayOrder(1)->update(['image_path' => 'uploads/products/' . $imageName]);
        }
        if ($request->hasFile('image_1')) {
            $image_file = $request->file('image_1');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/products'), $imageName);
            Image::whereType('product')->whereContentId($product_id)->whereDisplayOrder(2)->update(['image_path' => 'uploads/products/' . $imageName]);
        }
        if ($request->hasFile('image_2')) {
            $image_file = $request->file('image_2');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/products'), $imageName);
            Image::whereType('product')->whereContentId($product_id)->whereDisplayOrder(3)->update(['image_path' => 'uploads/products/' . $imageName]);
        }

        $msg = isset($request_data['product_id']) && !empty($request_data['product_id']) ? 'updated' : 'created';
        $msg1 = isset($request_data['product_id']) && !empty($request_data['product_id']) ? 'Updating' : 'Creating';
        if ($product) {
            session()->flash('success', 'Product details ' . $msg . ' successfully.');
            return redirect(url('admin/products/' . $product_id));
        } else {
            session()->flash('error', $msg1 . ' product details failed, Please try again.');
            return redirect()->back();
        }
    }

    public function saveVariants(Request $request) {
        $post_data = $request->all();
        $save = true;
        if(isset($post_data['variant_id']) && !empty($post_data['variant_id'])) {
            $save = Variant::find($post_data['variant_id'])->update($post_data);
        }
        if($save) {
            return response()->json(['status' => true, 'message' => 'Variant details updated successfully.']);
        }
        return response()->json(['status' => false, 'message' => 'Something went wrong, Please try again.']);
    }

    public function createVariants(Request $request) {
        $post_data = $request->all();
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again'];
        if(!empty($post_data['grind_ids']) && !empty($post_data['weight_ids']) && !empty($post_data['add_variant'])) {
            $grind_ids = implode(',', $post_data['grind_ids']);
            foreach($post_data['weight_ids'] as $weight_id) {
                $variant = [
                    'product_id' => $request->product_id,
                    'weight_id' => $weight_id,
                    'grind_ids' => $grind_ids,
                    'price' => $post_data['add_variant'][$weight_id]['price'],
                    'quantity' => $post_data['add_variant'][$weight_id]['quantity'],
                    'reward_point' => $post_data['add_variant'][$weight_id]['reward_point'],
                    'status' => 1
                ];
                Variant::create($variant);
            }
            $response = ['status' => true, 'message' => 'Variant details added successfully.'];
        }
        return response()->json($response);
    }
}
