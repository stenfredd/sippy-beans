<?php

use App\Models\TaxClass;
use Illuminate\Database\Seeder;

class TaxClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (TaxClass::count() == 0) {
            $classes = [
                '5'
            ];

            foreach ($classes as $class) {
                TaxClass::create([
                    'class' => $class,
                    'status' => 1
                ]);
            }
        }
    }
}
