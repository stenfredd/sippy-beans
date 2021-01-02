<?php

use App\Models\Characteristic;
use Illuminate\Database\Seeder;

class CharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Characteristic::count() == 0) {
            $characteristics = [
                'Chocolaty & Sweet',
                'Sweet & Tart',
                'Funky & Fruity',
                'Sweet & Inviting',
                'Comforting & Rich',
                'Subtle & Delicate',
                'Sweet & Smooth',
                'Balanced & Fruity',
                'Earthy & Rich'
            ];
            foreach ($characteristics as $key => $characteristic) {
                Characteristic::create([
                    'title' => $characteristic,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
