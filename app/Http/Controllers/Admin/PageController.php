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

    public function createDeliveryAreas(Request $request)
    {
        view()->share('page_title', 'Add New Delivery Areas');
        if (!empty($request->all())) {
            $validation = [
                'country_name' => 'required',
                'city_name' => 'required',
                'delivery_fee' => 'required',
                'delivery_time' => 'required',
                // 'currency' => 'required'
            ];
            $this->validate($request, $validation);

            // $request_data = $request->all();
            $country = Country::select('id')->whereCountryName($request->country_name)->first();
            if(empty($country)) {

                /* $validation = [
                    'flag_image' => 'required',
                    // 'currency' => 'required',
                ];
                $this->validate($request, $validation); */

                $flag_image = '';
                if($request->hasFile('flag_image')) {
                    $file = $request->file('flag_image');
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path() . '/uploads/images/';
                    $file->move($destinationPath, $fileName);
                    $flag_image = 'uploads/images/' . $fileName;
                }

                $country = Country::create([
                    'country_name' => $request->country_name,
                    'flag_image' => $flag_image,
                    'currency' => $request->currency ?? 'AED',
                    'status' => 1
                ]);
            }
            // $area = City::find($request_data['city_id'])->update($request_data);
            $city = City::firstOrCreate(
                ['country_id' => $country->id, 'name' => $request->city_name],
                [
                    'display_order' => (City::count() + 1),
                    'delivery_fee' => $request->delivery_fee,
                    'delivery_time' => $request->delivery_time,
                    'status' => 1
                ]
            );

            if ($city) {
                session()->flash('success', 'Delivery area details added successfully.');
                return redirect(url('admin/delivery-areas/' . $request->city_id));
            } else {
                session()->flash('error', 'Adding delivery area details failed, Please try again.');
                return redirect()->back();
            }
            return redirect('admin/delivery-areas');
        }
        $countries = [
            'Afghanistan',
            'Albania',
            'Algeria',
            'Andorra',
            'Angola',
            'Antigua & Deps',
            'Argentina',
            'Armenia',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belgium',
            'Belize',
            'Benin',
            'Bhutan',
            'Bolivia',
            'Bosnia Herzegovina',
            'Botswana',
            'Brazil',
            'Brunei',
            'Bulgaria',
            'Burkina',
            'Burundi',
            'Cambodia',
            'Cameroon',
            'Canada',
            'Cape Verde',
            'Central African Rep',
            'Chad',
            'Chile',
            'China',
            'Colombia',
            'Comoros',
            'Congo',
            'Congo {Democratic Rep}',
            'Costa Rica',
            'Croatia',
            'Cuba',
            'Cyprus',
            'Czech Republic',
            'Denmark',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'East Timor',
            'Ecuador',
            'Egypt',
            'El Salvador',
            'Equatorial Guinea',
            'Eritrea',
            'Estonia',
            'Ethiopia',
            'Fiji',
            'Finland',
            'France',
            'Gabon',
            'Gambia',
            'Georgia',
            'Germany',
            'Ghana',
            'Greece',
            'Grenada',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Guyana',
            'Haiti',
            'Honduras',
            'Hungary',
            'Iceland',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Ireland {Republic}',
            'Israel',
            'Italy',
            'Ivory Coast',
            'Jamaica',
            'Japan',
            'Jordan',
            'Kazakhstan',
            'Kenya',
            'Kiribati',
            'Korea North',
            'Korea South',
            'Kosovo',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Lesotho',
            'Liberia',
            'Libya',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Macedonia',
            'Madagascar',
            'Malawi',
            'Malaysia',
            'Maldives',
            'Mali',
            'Malta',
            'Marshall Islands',
            'Mauritania',
            'Mauritius',
            'Mexico',
            'Micronesia',
            'Moldova',
            'Monaco',
            'Mongolia',
            'Montenegro',
            'Morocco',
            'Mozambique',
            'Myanmar',
            '{Burma}',
            'Namibia',
            'Nauru',
            'Nepal',
            'Netherlands',
            'New Zealand',
            'Nicaragua',
            'Niger',
            'Nigeria',
            'Norway',
            'Oman',
            'Pakistan',
            'Palau',
            'Panama',
            'Papua New Guinea',
            'Paraguay',
            'Peru',
            'Philippines',
            'Poland',
            'Portugal',
            'Qatar',
            'Romania',
            'Russian Federation',
            'Rwanda',
            'St Kitts & Nevis',
            'St Lucia',
            'Saint Vincent & the Grenadines',
            'Samoa',
            'San Marino',
            'Sao Tome & Principe',
            'Saudi Arabia',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Sierra Leone',
            'Singapore',
            'Slovakia',
            'Slovenia',
            'Solomon Islands',
            'Somalia',
            'South Africa',
            'South Sudan',
            'Spain',
            'Sri Lanka',
            'Sudan',
            'Suriname',
            'Swaziland',
            'Sweden',
            'Switzerland',
            'Syria',
            'Taiwan',
            'Tajikistan',
            'Tanzania',
            'Thailand',
            'Togo',
            'Tonga',
            'Trinidad & Tobago',
            'Tunisia',
            'Turkey',
            'Turkmenistan',
            'Tuvalu',
            'Uganda',
            'Ukraine',
            'United Arab Emirates',
            'United Kingdom',
            'United States',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Vatican City',
            'Venezuela',
            'Vietnam',
            'Yemen',
            'Zambia',
            'Zimbabwe'
        ];
        return view('admin.pages.create_delivery_areas', compact('countries'));
    }
}
