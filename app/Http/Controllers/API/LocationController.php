<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function countries()
    {
        $countries = Country::whereStatus(1)->get();
        return response()->json(['status' => true, 'countries' => ($countries ?? [])]);
    }

    public function cities(Request $request)
    {
        $request->validate([
            'country_id' => 'required'
        ]);

        $cities = City::whereStatus(1)->whereCountryId($request->country_id)->orderBy('display_order', 'asc')->get();
        return response()->json(['status' => true, 'cities' => ($cities ?? [])]);
    }
}
