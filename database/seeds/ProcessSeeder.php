<?php

use App\Models\Process;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Process::count() == 0) {
            $processes = [
                'Natural',
                'Washed Process',
                'Dry Process',
                'Honey Process',
                'Semi Washed',
                'Pulp Natural',
                'Wet Hulled',
                'Anaerobic Natural',
                'Black Honey',
                'Varied',
                'Sun-Dried Natural',
                'Carbonic Maceration',
                'Ethyl Acetate Decaffeinated',
                'Fermented'
            ];

            foreach ($processes as $key => $process) {
                Process::create([
                    'title' => $process,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
