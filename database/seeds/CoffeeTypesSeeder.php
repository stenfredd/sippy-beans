<?php

use App\Models\CoffeeType;
use Illuminate\Database\Seeder;

class CoffeeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (CoffeeType::count() == 0) {
            $types = [
                'Local Roaster', 'International Roaster'
            ];

            foreach ($types as $key => $type) {
                CoffeeType::create([
                    'title' => $type,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
