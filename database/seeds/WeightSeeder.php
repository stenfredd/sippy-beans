<?php

use App\Models\Weight;
use Illuminate\Database\Seeder;

class WeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Weight::count() == 0) {
            $weights = [
                [
                    'title' => '20g',
                    'type' => 'gram',
                    'weight' => '20',
                    'grams' => '20',
                    'display_order' => '1',
                    'status' => 1
                ],
                [
                    'title' => '100g',
                    'type' => 'gram',
                    'weight' => '100',
                    'grams' => '100',
                    'display_order' => '2',
                    'status' => 1
                ],
                [
                    'title' => '130g',
                    'type' => 'gram',
                    'weight' => '130',
                    'grams' => '130',
                    'display_order' => '3',
                    'status' => 1
                ],
                [
                    'title' => '150g',
                    'type' => 'gram',
                    'weight' => '150',
                    'grams' => '150',
                    'display_order' => '4',
                    'status' => 1
                ],
                [
                    'title' => '200g',
                    'type' => 'gram',
                    'weight' => '200',
                    'grams' => '200',
                    'display_order' => '5',
                    'status' => 1
                ],
                [
                    'title' => '225g',
                    'type' => 'gram',
                    'weight' => '225',
                    'grams' => '225',
                    'display_order' => '6',
                    'status' => 1
                ],
                [
                    'title' => '250g',
                    'type' => 'gram',
                    'weight' => '250',
                    'grams' => '250',
                    'display_order' => '7',
                    'status' => 1
                ],
                [
                    'title' => '500g',
                    'type' => 'gram',
                    'weight' => '500',
                    'grams' => '500',
                    'display_order' => '8',
                    'status' => 1
                ],
                [
                    'title' => '750g',
                    'type' => 'gram',
                    'weight' => '750',
                    'grams' => '750',
                    'display_order' => '9',
                    'status' => 1
                ],
                [
                    'title' => '1Kg',
                    'type' => 'kilogram',
                    'weight' => '1',
                    'grams' => '1000',
                    'display_order' => '10',
                    'status' => 1
                ]
            ];

            foreach ($weights as $weight) {
                Weight::create($weight);
            }
        }
    }
}
