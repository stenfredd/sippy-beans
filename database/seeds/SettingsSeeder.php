<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Setting::count() == 0) {
            $settings = [
                [
                    'setting_key' => "app_name",
                    'setting_value' => env('APP_NAME')
                ],
                [
                    'setting_key' => "timezone",
                    'setting_value' => env('ADMIN_TIMEZONE', 'Asia/Kolkata')
                ],
                [
                    'setting_key' => "currency_name",
                    'setting_value' => "United Arab Emirates dirham"
                ],
                [
                    'setting_key' => "currency_code",
                    'setting_value' => "AED"
                ],
                [
                    'setting_key' => "currency_symbol",
                    'setting_value' => "د.إ"
                ],
                [
                    'setting_key' => "delivery_fee",
                    'setting_value' => "0"
                ],
                [
                    'setting_key' => "tax_charges",
                    'setting_value' => "0"
                ],
                [
                    'setting_key' => "allow_cash_payment",
                    'setting_value' => true
                ]
            ];

            foreach ($settings as $setting) {
                Setting::create($setting);
            }
        }
    }
}
