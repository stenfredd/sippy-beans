<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Grind;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get(Request $request)
    {
        $page = $request->input('page') ?? 1;
        $search = $request->input('search') ?? "";
        $price = $request->input('price') ?? 0;
        $origin_id = $request->input('origin_id') ?? "";
        $brand_id = $request->input('brand_id') ?? "";
        $characteristic_id = $request->input('characteristic_id') ?? "";
        $best_for_id = $request->input('best_for_id') ?? "";
        $type_id = $request->input('type_id') ?? "";
        $coffee_type_id = $request->input('coffee_type_id') ?? "";
        $level_id = $request->input('level_id') ?? "";
        $process_id = $request->input('process_id') ?? "";
        $weight_id = $request->input('weight_id') ?? "";
        $is_favourite_products = $request->input('is_favourite') ?? 0;

        $limit = 20;
        $start = ($page - 1) * $limit;

        $products = Product::whereStatus(1);
        if (!empty($search)) {
            $products = $products->where(function ($query) use ($search) {
                $query->where('product_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
        if(!empty($price)) {
            $price = explode('-', $price);
            $variants = Variant::whereBetween('price', $price)->get();
            $product_ids = !empty($variants) && count($variants) ? array_column($variants->toArray(), 'product_id') : [0];
            $products = $products->whereIn('id', $product_ids);
        }
        if(!empty($origin_id)) {
            $products = $products->whereIn('origin_id', explode(',', $origin_id));
        }
        if(!empty($brand_id)) {
            $products = $products->whereIn('brand_id', explode(',', $brand_id));
        }
        if(!empty($characteristic_id)) {
            $products = $products->whereIn('characteristic_id', explode(',', $characteristic_id));
        }
        if(!empty($best_for_id)) {
            $products = $products->whereIn('best_for_id', explode(',', $best_for_id));
        }
        if(!empty($coffee_type_id)) {
            $products = $products->whereIn('coffee_type_id', explode(',', $coffee_type_id));
        }
        if(!empty($type_id)) {
            $products = $products->whereIn('type_id', explode(',', $type_id));
        }
        if(!empty($level_id)) {
            $products = $products->whereIn('level_id', explode(',', $level_id));
        }
        if(!empty($process_id)) {
            $products = $products->whereIn('process_id', explode(',', $process_id));
        }
        if(!empty($weight_id)) {
            $variants = Variant::where('weight_id', $weight_id)->get();
            $product_ids = !empty($variants) && count($variants) ? array_column($variants->toArray(), 'product_id') : [0];
            $products = $products->whereIn('id', $product_ids);
        }
        if(!empty($is_favourite_products)) {
            $favourite_products = Favourite::select('product_id')->where('user_id', (auth('api')->id() ?? 0))->get();
            $product_ids = !empty($favourite_products) && count($favourite_products) ? array_column($favourite_products->toArray(), 'product_id') : [0];
            $products = $products->whereIn('id', $product_ids);
        }

        $total_products = $products->count();
        $products = $products->with(['images', 'variants', 'variants.images', 'weights'])->offset($start)->limit($limit)->orderBy('display_order', 'asc')->get();
        $total_pages = (ceil($total_products / $limit)) ?? 1;
        foreach($products as $product) {
            $product_grind_ids = [];
            // $product->grinds = Grind::whereIn('id', (explode(',', $product->variants[0]->grind_ids) ?? []))->get() ?? [];
            if(!empty($product->variants)) {
                foreach($product->variants as $variant) {
                    $variant->available_quantity = $variant->quantity ?? 0;
                    $product_grind_ids = array_merge($product_grind_ids, (explode(',', $product->variants[0]->grind_ids) ?? []));
                }
            }
            $product->grinds = Grind::whereIn('id', $product_grind_ids)->get() ?? [];
        }

        $response = [
            'status' => true,
            'total_pages' => $total_pages,
            'total_products' => $total_products,
            'products' => $products
        ];
        return response()->json($response);
    }
}
