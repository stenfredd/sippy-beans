<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $contact_us = Page::wherePage('contact-us')->first();
        $privacy_policy = Page::wherePage('privacy-policies')->first();
        $terms_conditions = Page::wherePage('terms-conditions')->first();
        $faqs = Page::wherePage('faq')->first();
        view()->share('page_title', 'Service Policies');
        return view('admin.pages.service-policies', compact('contact_us', 'privacy_policy', 'terms_conditions', 'faqs'));
    }

    public function save(Request $request)
    {
        $page_data = $request->except('_token');
        $save = Page::where('page', $request->page)->update($page_data);
        session()->flash('success', 'Page details saved successfully.');
        return redirect(url('admin/service-policies'));
    }

    public function deliveryAreas(Request $request)
    {
        view()->share('page_title', 'Delivery Areas');
        if (!empty($request->all())) {
            $validation = [
                'city_id' => 'required'
            ];
            $this->validate($request, $validation);

            $request_data = $request->all();
            $area = City::find($request_data['city_id'])->update($request_data);

            if (!$request->ajax()) {
                if ($area) {
                    session()->flash('success', 'Delivery area details updated successfully.');
                    return redirect(url('admin/delivery-areas/' . $request->city_id));
                } else {
                    session()->flash('error', 'Updating delivery area details failed, Please try again.');
                    return redirect()->back();
                }
            } else {
                $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
                if ($area) {
                    $response = ['status' => true, 'message' => 'Delivery area details updated successfully.'];
                }
                return response()->json($response);
            }
        }
        $delivery_areas = City::with('country')->orderBy('display_order')->get();
        return view('admin.pages.delivery_areas', compact('delivery_areas'));
    }

    public function editDeliveryAreass(Request $request, $city_id = null)
    {
        view()->share('page_title', 'Edit Delivery Area');
        $delivery_area = City::with('country')->orderBy('display_order')->find($city_id);
        $countries = Country::whereStatus(1)->get();
        return view('admin.pages.edit_delivery_areas', compact('delivery_area', 'countries'));
    }

    public function updateAreasSortOrders(Request $request)
    {
        $request->validate([
            'sorting_areas' => 'required'
        ]);

        $sorting_areas = json_decode($request->sorting_areas, true);
        foreach ($sorting_areas as $service) {
            City::find($service['city_id'])->update(['display_order' => $service['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Delivery area sorting order applied successfully.'];
        return response()->json($response);
    }

    public function taxCharges(Request $request)
    {
        view()->share('page_title', 'Tax Charges');
        if (isset($request->tax_charges)) {
            Setting::where('setting_key', 'tax_charges')->update(['setting_value' => $request->tax_charges]);
            session()->flash('success', 'Tax details updated successfully.');
            return redirect(url('admin/tax-charges'));
        }
        return view('admin.pages.tax_charges');
    }
}
