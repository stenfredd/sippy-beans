<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Grind;
use App\Models\MatchMakers;
use App\Models\Page;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\UserMatchMaker;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function home()
    {
        $banners = Banner::whereStatus(1)->orderBy('display_order', 'asc')->get()->each(function($banner) {
            $banner->product = null;
            $banner->equipment = null;
            if(!empty($banner->product_id)) {
                $banner->product = Product::with(['variants', 'variants.images', 'images', 'weights'])->find($banner->product_id);
                $product_grind_ids = [];
                $banner->product->is_equipment = false;
                if (!empty($banner->product->variants)) {
                    foreach ($banner->product->variants as $variant) {
                        $variant->available_quantity = ($variant->quantity - (OrderDetail::where('variant_id', $variant->id)->sum('quantity'))) ?? 0;
                        $product_grind_ids = array_merge($product_grind_ids, (explode(',', $banner->product->variants[0]->grind_ids) ?? []));
                    }
                }
                $banner->product->grinds = Grind::whereIn('id', $product_grind_ids)->get() ?? [];
            }
            if (!empty($banner->equipment_id)) {
                $banner->equipment = Equipment::whereStatus(1)->latest()->with('images')->find($banner->equipment_id);
                $banner->equipment->is_equipment = true;
                $banner->equipment->available_quantity = $banner->equipment->quantity ?? 0;
            }
        });

        $categories_names = Category::whereStatus(1)->orderBy('display_order', 'asc')->get()->pluck('category_title') ?? [];

        $categories = [];
        if (auth('api')->check() && UserMatchMaker::whereUserId(auth('api')->user()->id)->count() > 0) {
            $match_makers = MatchMakers::whereStatus(1)->get();
            $where = [];
            foreach ($match_makers as $matchmaker) {
                $user_match_maker = UserMatchMaker::whereUserId(auth('api')->user()->id)->whereMatchMakerId($matchmaker->id)->first();
                if (!empty($matchmaker->type)) {
                    if ($matchmaker->type !== 'price') {
                        $where[$matchmaker->type . '_id'] = $user_match_maker->values ?? '';
                    }
                }
            }

            $product_exist_ids = [];
            RE_SYNC_DATA:
            if(!empty(request()->input('product_ids'))) {
                $products = Product::with(['variants', 'variants.images', 'images', 'weights']);
                $products = $products->whereIn('id', explode(',', request()->input('product_ids')));
                $products = $products->limit(10)->get();
            }
            else {
                $products = Product::with(['variants', 'variants.images', 'images', 'weights'])
                    ->inRandomOrder()->latest();
                foreach ($where as $k => $wh) {
                    $products = $products->whereIn($k, explode(',', $wh));
                }
                if (!empty($product_exist_ids)) {
                    $products = $products->whereNotIn('id', $product_exist_ids);
                }
                $products = $products->limit(10)->get();
            }

            if (count($products) < 10) {
                if (!empty($products)) {
                    $product_exist_ids = array_merge($product_exist_ids, array_column($products->toArray(), 'id'));
                }
                array_pop($where);
                goto RE_SYNC_DATA;
            }

            foreach ($products as $product) {
                $product_grind_ids = [];
                $product->is_equipment = false;
                if (!empty($product->variants)) {
                    foreach ($product->variants as $variant) {
                        $variant->available_quantity = ($variant->quantity - (OrderDetail::where('variant_id', $variant->id)->sum('quantity'))) ?? 0;
                        $product_grind_ids = array_merge($product_grind_ids, (explode(',', $product->variants[0]->grind_ids) ?? []));
                    }
                }
                $product->grinds = Grind::whereIn('id', $product_grind_ids)->get() ?? [];
            }
            $category_info = [
                'id' => null,
                'icon' => asset(env('SUGGEST_CATEGORY_ICON', 'uploads/types/suggested.png')),
                'is_equipment' => false,
                'title' => 'Suggested for You',
                'description' => 'Top picks based on your taste.',
                'products' => $products
            ];
            $categories[] = $category_info;
        }

        foreach ($categories_names as $category) {
            $db_category = Category::whereStatus(1)->where('category_title', $category)->orderBy('display_order', 'asc')->first() ?? null;
            if (!empty($db_category) && isset($db_category->id)) {
                $products = Product::with(['variants', 'variants.images', 'images', 'weights'])->orderBy('display_order', 'asc')->where("category_id", $db_category->id)->limit(20)->get();
                $equipment = false;
                if (empty($products) || count($products) == 0) {
                    $equipment = true;
                    $products = Equipment::with(['images'])->orderBy('display_order', 'asc')->where("category_id", $db_category->id)->limit(20)->get();
                }
                foreach ($products as $product) {
                    $product->is_equipment = $equipment;
                    if ($equipment === false) {
                        $product_grind_ids = [];
                        if (!empty($product->variants)) {
                            foreach ($product->variants as $variant) {
                                $variant->available_quantity = ($variant->quantity - (OrderDetail::where('variant_id', $variant->id)->sum('quantity'))) ?? 0;
                                $product_grind_ids = [];
                                if(!empty($product->variants)) {
                                	$product_grind_ids = array_merge($product_grind_ids, (explode(',', $product->variants[0]->grind_ids) ?? []));
                                }
                            }
                        }
                        $product->grinds = Grind::whereIn('id', (explode(',', ($product->variants[0]->grind_ids ?? '')) ?? []))->get();
                    }
                    else {
                        $product->available_quantity = ($product->quantity - (OrderDetail::where('equipment_id', $product->id)->sum('quantity'))) ?? 0;
                    }
                }
                $category_info = [
                    'id' => $db_category->id,
                    'is_equipment' => $equipment,
                    'icon' => asset($db_category->image_url),
                    'title' => $db_category->category_title,
                    'description' => $db_category->description,
                    'products' => $products
                ];
                $categories[] = $category_info;
            }
        }

        $response = [
            'status' => true,
            'banners' => $banners,
            'categories' => $categories
        ];
        return response()->json($response);
    }

    public function pages()
    {
        $contact_us = Page::wherePage('contact-us')->first();
        $policies = Page::wherePage('privacy-policies')->first();
        $terms_conditions = Page::wherePage('terms-conditions')->first();
        $faqs = Page::wherePage('faq')->first();

        $response = [
            'status' => true,
            'contact_us' => $contact_us->description ?? null,
            'privacy_policies' => $policies->description ?? null,
            'terms_conditions' => $terms_conditions->description ?? null,
            'faqs' => $faqs->description ?? null
        ];
        return response()->json($response);
    }

    public function search(Request $request)
    {
        // products and equipment search api
        $request->validate([
            'search' => 'required'
        ]);

        $search = $request->input('search') ?? "";

        $brand_id = '0';
        $brands = Brand::where("name", "like", "%" . $search . "%")->orderBy('display_order', 'asc')->get();
        if (!empty($brands) && count($brands) > 0) {
            $brand_id = implode(',', array_column($brands->toArray(), 'id'));
        }

        $products = Product::whereStatus(1);
        $products = $products->where(function ($query) use ($search, $brand_id) {
            $query->where('product_name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhere('tags', 'LIKE', '%' . $search . '%')
                ->orWhereIn('brand_id', explode(',', $brand_id));
        });
        $total_products = $products->orderBy('id', 'asc')->groupBy('id')->count();

        $products = $products->with(['images', 'variants', 'variants.images', 'weights'])->orderBy('id', 'asc')->groupBy('id')->paginate(10);

        foreach ($products as $product) {
            $product_grind_ids = [];
            $product->is_product = true;
            if (!empty($product->variants)) {
                foreach ($product->variants as $variant) {
                    $variant->available_quantity = ($variant->quantity - (OrderDetail::where('variant_id', $variant->id)->sum('quantity'))) ?? 0;
                    $product_grind_ids = array_merge($product_grind_ids, (explode(',', $product->variants[0]->grind_ids) ?? []));
                }
            }
            $product->grinds = Grind::whereIn('id', $product_grind_ids)->get() ?? [];
        }

        $equipments = Equipment::whereStatus(1)->latest();
        $equipments = $equipments->where(function ($query) use ($search, $brand_id) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%')
                ->orWhereIn('brand_id', explode(',', $brand_id));
        });

        $total_equipments = $equipments->orderBy('id', 'asc')->count();
        $equipments = $equipments->with('images')->paginate(10);
        foreach ($equipments as $equipment) {
            $equipment->is_equipment = true;
            $equipment->available_quantity = ($equipment->quantity - (OrderDetail::where('equipment_id', $equipment->id)->sum('quantity'))) ?? 0;
        }

        $total_data = $total_products > $total_equipments ? $total_products : $total_equipments;
        $total_pages = ceil($total_data / 10);

        $response = [
            'status' => true,
            'cur_page' => (int) $request->page ?? 1,
            'total_pages' => $total_pages,
            'products' => $products->items(),
            'equipments' => $equipments->items()
        ];

        return response()->json($response);
    }
}
