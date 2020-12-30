<?php

use App\Models\BestFor;
use Illuminate\Database\Seeder;

class BestforSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(BestFor::count() == 0)
        {
            $best_fors = [
                'Filter', 'Espresso', 'Filter or Espresso', 'Filter, Espresso or Milkbased',
                'Arabic Gahwa', 'Espresso or Milkbased', 'Tea', 'Cold Brew', 'Instant Coffee',
                'All Brewing Methods', 'Milkbased'
            ];

            foreach($best_fors as $best_for)
            {
                BestFor::create([
                    'title' => $best_for,
                    'status' => 1
                ]);
            }
        }
    }
}
