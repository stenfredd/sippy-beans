<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Category::count() == 0) {
            $categories = [
                'Local Roasters',
                'International Roasters',
                'Competition Beans',
                'Limited Edition Roaster',
                'Coffee Equipments'
            ];

            $description = [
                'Top local brands to try!',
                'Top international brands to try!',
                'The tops beans in town.',
                'Our selection to brew.',
                'Coffee Equipments'
            ];

            foreach ($categories as $key => $category) {
                Category::create([
                    'image_url' => 'uploads/categories/' . strtolower(str_replace(" ", "_", $category)) . '.png',
                    'category_title' => $category,
                    'description' => $description[$key],
                    'status' => 1,
                    'display_order' => ($key + 1)
                ]);
            }
        }
    }
}
