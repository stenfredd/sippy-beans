<?php

use App\Models\Seller;
use Illuminate\Database\Seeder;

class SellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Seller::count() == 0) {
            $sellers = [
                [
                    'name' => "Mohit's Coffee Shop",
                    'email' => "mohit@hypeten.com"
                ],
                [
                    'name' => "Mohit's Café",
                    'email' => "hello@hypeten.com"
                ]
            ];

            foreach ($sellers as $key => $seller) {
                Seller::create([
                    'seller_name' => $seller['name'],
                    'seller_info' => $seller['name'],
                    'seller_image' => null,
                    'seller_address' => null,
                    'seller_phone' => null,
                    'seller_email' => $seller['email'],
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
