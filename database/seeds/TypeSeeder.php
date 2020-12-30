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
        if(Type::count() == 0)
        {
            $types = [
                'Local Roasters',
                'International Roasters',
                // 'Competition Beans',
                // 'Limited Edition Roaster',
            ];

            // $description = [
            //     'Top local brands to try!',
            //     'Top international brands to try!',
            //     'The tops beans in town.',
            //     'Our selection to brew.'
            // ];

            foreach ($types as $key => $type)
            {
                Type::create([
                    // 'type_icon' => 'uploads/types/' . strtolower(str_replace(" ", "_", $type)) . '.png',
                    'title' => $type,
                    // 'description' => $description[$key],
                    'status' => 1,
                    'display_order' => ($key + 1)
                ]);
            }
        }
    }
}
