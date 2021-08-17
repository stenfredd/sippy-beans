<?php

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'United Arab Emirates'
        ];

        if (Country::count() == 0) {
            foreach ($countries as $country) {
                Country::create([
                    'flag_image' => 'assets/images/uae-flag.png',
                    'country_name' => $country,
                    'currency' => 'AED',
                    'status' => 1
                ]);
            }
        }

        if (City::count() == 0) {
            foreach ($countries as $country) {
                if ($country == 'United Arab Emirates') {
                    $cities = [
                        'Dubai', 'Abu Dhabi', 'Ajman', 'Fujairah', 'Ras Al Khaimah', 'Sharjah', 'Umm Al Quwain'
                    ];
                    foreach ($cities as $k => $city) {
                        City::create([
                            'country_id' => 1,
                            'name' => $city,
                            'delivery_fee' => rand(0, 30),
                            'delivery_time' => '1-3 Business Days',
                            'display_order' => ($k + 1),
                            'status' => ($city == 'Dubai' ? 1 : 0)
                        ]);
                    }
                }
            }
        }
    }
}
