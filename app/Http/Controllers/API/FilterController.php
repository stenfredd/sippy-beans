<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BestFor;
use App\Models\Brand;
use App\Models\Characteristic;
use App\Models\Level;
use App\Models\Origin;
use App\Models\Price;
use App\Models\Process;
use App\Models\Type;
use App\Models\Weight;

class FilterController extends Controller
{
    public function get()
    {
        /* $prices = [
            ['title' => '40-60'],
            ['title' => '60-80'],
            ['title' => '80-100'],
            ['title' => '100-120'],
            ['title' => '120-140'],
            ['title' => '140-160'],
            ['title' => '160-180']
        ]; */

        $prices = Price::selectRaw('id, title, min_price, max_price')->whereStatus(1)->orderBy('id', 'asc')->get();
        $origins = Origin::selectRaw('id, origin_name as title')->whereStatus(1)->orderBy('id', 'asc')->get();
        $brands = Brand::selectRaw('id, name as title')->whereStatus(1)->orderBy('display_order', 'asc')->get();
        $characteristic = Characteristic::select('id', 'title')->whereStatus(1)->orderBy('id', 'asc')->get();
        $best_fors = BestFor::select('id', 'title')->whereStatus(1)->orderBy('display_order', 'asc')->get();
        $types = Type::select('id', 'title')->whereStatus(1)->orderBy('display_order', 'asc')->get();
        $levels = Level::selectRaw('id, level_title as title')->whereStatus(1)->orderBy('display_order', 'asc')->get();
        $processes = Process::select('id', 'title')->whereStatus(1)->orderBy('display_order', 'asc')->get();
        $weights = Weight::select('id', 'title')->whereStatus(1)->orderBy('id', 'asc')->get();

        $filters = [
            [
                'title' => 'Price',
                'values' => $prices
            ],
            [
                'title' => 'Origin',
                'values' => $origins
            ],
            [
                'title' => 'Brands',
                'values' => $brands
            ],
            [
                'title' => 'Characteristic',
                'values' => $characteristic
            ],
            [
                'title' => 'Best For',
                'values' => $best_fors
            ],
            [
                'title' => 'Type',
                'values' => $types
            ],
            [
                'title' => 'Levels',
                'values' => $levels
            ],
            [
                'title' => 'Process',
                'values' => $processes
            ],
            [
                'title' => 'Weight',
                'values' => $weights
            ]
        ];

        $response = [
            'status' => true,
            'filters' => $filters
        ];

        return response()->json($response);
    }
}
