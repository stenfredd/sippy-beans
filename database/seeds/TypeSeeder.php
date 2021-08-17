<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Type::count() == 0) {
            $types = [
                'Local Roasters',
                'International Roasters'
            ];

            foreach ($types as $key => $type) {
                Type::create([
                    'title' => $type,
                    'status' => 1,
                    'display_order' => ($key + 1)
                ]);
            }
        }
    }
}
