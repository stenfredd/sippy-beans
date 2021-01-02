<?php

use App\Models\CoffeeFlavor;
use Illuminate\Database\Seeder;

class CoffeeFlavourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (CoffeeFlavor::count() == 0) {
            $coffee_flavors = [
                'Balanced & Fruity',
                'Chocolate & Sweet',
                'Comferting & Rich',
                'Rosty & Smoky',
                'Funky & Fruity',
                'Subtle & Delicate',
                'Sweet & Inviting',
                'Sweet & Smooth'
            ];
            foreach ($coffee_flavors as $flavor) {
                CoffeeFlavor::create([
                    'flavor_name' => $flavor,
                    'status' => 1
                ]);
            }
        }
    }
}
