<?php

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Banner::count() == 0) {
            $banners = [
                [
                    'title' => 'Intro Banner',
                    'description' => 'Intro Banner',
                    'image_url' => 'uploads/banners/1.png',
                    'display_order' => 1,
                    'url' => url('admin'),
                    'status' => 1
                ],
                [
                    'title' => 'Subscription',
                    'description' => 'Subscription',
                    'image_url' => 'uploads/banners/2.png',
                    'display_order' => 2,
                    'status' => 1
                ],
                [
                    'title' => 'Premium Beans Banner',
                    'description' => 'Premium Beans Banner',
                    'image_url' => 'uploads/banners/3.png',
                    'display_order' => 3,
                    'status' => 1
                ],
                [
                    'title' => 'Equipment Banner',
                    'description' => 'Equipment Banner',
                    'image_url' => 'uploads/banners/4.png',
                    'display_order' => 4,
                    'status' => 1
                ],
                [
                    'title' => 'Matchmaker Banner',
                    'description' => 'Matchmaker Banner',
                    'image_url' => 'uploads/banners/5.png',
                    'display_order' => 5,
                    'status' => 1
                ]
            ];

            foreach ($banners as $banner) {
                Banner::create($banner);
            }
        }
    }
}
