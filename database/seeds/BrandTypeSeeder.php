<?php

use App\Models\BrandType;
use Illuminate\Database\Seeder;

class BrandTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (BrandType::count() == 0) {
            $types = ['Local', 'International'];

            foreach ($types as $type) {
                BrandType::create([
                    'title' => $type,
                    'status' => 1
                ]);
            }
        }
    }
}
