<?php

use App\Models\Equipment;
use App\Models\Image;
use Illuminate\Database\Seeder;

class EquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Equipment::count() == 0) {
            $equipments = [
                [
                    'title' => 'Kalita Stainless Steel Wave',
                    'short_description' => 'The \'Wave\' has a flat, three-holed bottom which restricts the flow of water, simplifying the overall process.',
                    'description' => 'Predictable & easy to use, produces stronger more concentrated coffee, classic design makes it attractive.',
                    'sku' => strtolower(str_replace(' ', '-', 'Kalita Stainless Steel Wave')),
                    'price' => '215',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '21',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Chemex',
                    'short_description' => 'Looks like science, tastes like magic.',
                    'description' => 'Timeless classic design, 3-10 cup sizes, brews clean rich coffee.',
                    'sku' => strtolower(str_replace(' ', '-', 'Chemex')),
                    'price' => '270',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '22',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Pearl White Scale',
                    'short_description' => 'Simple, precise & designed just for coffee!',
                    'description' => 'Beautiful design, Incredibly precise, connects scale to Acaia app via Bluetooth to record your brew, has 6 different modes.',
                    'sku' => strtolower(str_replace(' ', '-', 'Pearl White Scale')),
                    'price' => '830',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '23',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'V60 Ceramic Dripper',
                    'short_description' => 'If you want to test your skills, this is for you! ',
                    'description' => 'Completely open source coffee brewer, a wide range of options, upgraded design has improved air flow.',
                    'sku' => strtolower(str_replace(' ', '-', 'V60 Ceramic Dripper')),
                    'price' => '118',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '24',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Gooseneck Kettle 600mL',
                    'short_description' => 'Plug-in and pour over with this water heating hero.',
                    'description' => 'Precise digital control. Celsius to Farenheit. Auto-off function after 60 minutes. Beautiful design. Durable.',
                    'sku' => strtolower(str_replace(' ', '-', 'Gooseneck Kettle 600mL')),
                    'price' => '660',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '25',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Smart Scale (Silver)',
                    'short_description' => 'Simple, precise & designed just for coffee!',
                    'description' => 'Built to withstand the demands and wet environment of a professional coffee shop, the Brewista Smart Scale is perfect for coffee and food preparation!',
                    'sku' => strtolower(str_replace(' ', '-', 'Smart Scale (Silver)')),
                    'price' => '395',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '25',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Chemex Filters',
                    'short_description' => 'Comes in 150 pieces. Thicker design to keep all elements in their place before reaching your cup. Prefolded.',
                    'description' => 'Learning to perfect your brewing process with this coffee maker is going to take some practice and experimentation (get a coffee journal if you don’t already have one).',
                    'sku' => strtolower(str_replace(' ', '-', 'Chemex Filters')),
                    'price' => '150',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '22',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'V60 Filters',
                    'short_description' => 'Comes in 40 pieces.',
                    'description' => 'The V60 uses some of the thinnest paper filters to keep water flowing smoothly without interruption.',
                    'sku' => strtolower(str_replace(' ', '-', 'V60 Filters')),
                    'price' => '31',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '24',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Wave Filters',
                    'short_description' => 'Comes in 100 pieces. The Kalita Wave’s paper filters, with their wavy, vertical ridges, look like an oversized cupcake cup.',
                    'description' => 'One thing to be careful of with these filters is that, without proper storage, they can easily lose their shape. If you store them upright or in the actual Wave cone then they will be fine, but simply tossing them in the cupboard won’t do.',
                    'sku' => strtolower(str_replace(' ', '-', 'Wave Filters')),
                    'price' => '63',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '21',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ],
                [
                    'title' => 'Range Server',
                    'short_description' => 'Hario means King of Glass!',
                    'description' => 'Easy to use and clean.',
                    'sku' => strtolower(str_replace(' ', '-', 'Range Server')),
                    'price' => '150',
                    'reward_point' => '0',
                    'quantity' => '100',
                    'weight' => '1Kg',
                    'brand_id' => '24',
                    'type_id' => null,
                    'seller_id' => '1',
                    'tax_class_id' => '1',
                    'category_id' => '5',
                    'status' => '1',
                ]
            ];

            foreach ($equipments as $key => $equipment) {
                $product['display_order'] = ($key + 1);
                $save = Equipment::create($equipment);
                if ($save) {
                    $images = [
                        [
                            'type' => 'equipment',
                            'content_id' => $save->id,
                            'image_path' => 'uploads/equipments/' . $equipment['title'] . '/' . $save->id . '.png',
                            'display_order' => 1,
                            'status' => 1
                        ],
                        [
                            'type' => 'equipment',
                            'content_id' => $save->id,
                            'image_path' => 'uploads/equipments/' . $equipment['title'] . '/' . $save->id . 'a.png',
                            'display_order' => 2,
                            'status' => 1
                        ],
                        [
                            'type' => 'equipment',
                            'content_id' => $save->id,
                            'image_path' => 'uploads/equipments/' . $equipment['title'] . '/' . $save->id . 'b.png',
                            'display_order' => 3,
                            'status' => 1
                        ]
                    ];
                    foreach ($images as $image) {
                        Image::create($image);
                    }
                }
            }
        }
    }
}
