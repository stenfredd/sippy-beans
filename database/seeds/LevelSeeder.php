<?php

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Level::count() == 0) {
            $levels = [
                'Light Roast',
                'Light Medium Roast',
                'Medium Roast',
                'Dark Roast',
                'Medium Light Roast',
                'Medium Dark Roast',
                'Omni Roast'
            ];

            foreach ($levels as $key => $level) {
                Level::create([
                    'level_title' => $level,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
