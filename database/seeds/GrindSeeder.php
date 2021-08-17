<?php

use App\Models\Grind;
use Illuminate\Database\Seeder;

class GrindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Grind::count() == 0) {
            $grinds = [
                'Whole Beans-type-1',
                'Extra Coarse (Cold Brew)-type-1',
                'Coarse (French Press)-type-1',
                'Medium Coarse ( Chemex, Aeropress)-type-1',
                'Medium (V60 Pourover, Syphon, Aeropress)-type-1',
                'Medium Fine (Aeropress)-type-1',
                'Fine (Espresso, Moka Pot, Aeropress)-type-1',
                '5 Sachets-type-2',
                'Super Fine (Turkish)-type-2',
                '10 Sachets-type-2',
            ];

            foreach ($grinds as $key => $grind) {
                Grind::create([
                    'title' => explode('-type-', $grind)[0],
                    'grind_type' => explode('-type-', $grind)[1],
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
