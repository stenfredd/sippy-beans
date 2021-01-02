<?php

use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Price::count() == 0) {
            $prices = [
                [
                    'title' => '< AED 55',
                    'min_price' => 0,
                    'max_price' => 55,
                    'status' => 1,
                ],
                [
                    'title' => 'AED 55-65',
                    'min_price' => 55,
                    'max_price' => 65,
                    'status' => 1,
                ],
                [
                    'title' => 'AED 65-75',
                    'min_price' => 65,
                    'max_price' => 75,
                    'status' => 1,
                ],
                [
                    'title' => '> AED 75',
                    'min_price' => 75,
                    'max_price' => 0,
                    'status' => 1,
                ]
            ];

            foreach ($prices as $price) {
                Price::create($price);
            }
        }
    }
}
