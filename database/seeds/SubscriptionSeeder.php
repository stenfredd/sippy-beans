<?php

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Subscription::count() == 0) {
            Subscription::create([
                'grind_ids' => '1,2,3,4,5,6,7',
                'price_id' => env('STRIPE_PRICE_ID'),
                'product_id' => env('STRIPE_PRODUCT_ID'),
                'image_url' => 'uploads/subscriptions/subscription.png',
                'title' => 'SUBSCRIPTION BOX',
                'description' => 'MONTHLY DELIVERIES STRAIGHT TO YOUR DOOR',
                'price' => '99.00',
                'status' => 1,
            ]);
        }
    }
}
