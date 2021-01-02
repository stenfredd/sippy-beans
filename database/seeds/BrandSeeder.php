<?php

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Brand::count() == 0) {
            $brands = [
                /* 'Amor Perfecto', 'Café Rider', 'Cartel Coffee Roasters', 'Cupping Room',
                'Emirati Coffee', 'Fritz', 'Goldbox', 'Nightjar', 'NOW', 'Onibus', 'Refill Roastery',
                'Saraya Coffee Roasters', 'SEDNA', 'Seven Fortunes', 'Specialty Batch', 'The Barn',
                'THREE', 'Tres Marias', 'WANDERSONS', 'Nusantara', 'Blacksmith', 'BOON', 'Taf', 'Gardelli',
                'Grandmother Roastery', 'Local Brands', 'International Brands', 'Competition Brands',
                'Guest (Limited) Brands', 'Kaf Specialty Coffee', 'The Echo Cafe', 'Archers Coffee',
                'Five Elephant', 'NY Coffee Roastery' */
                'Goldbox', 'Tres Marias', 'Kaf Specialty Coffee', 'Seven Fortunes', 'Nightjar',
                'The Echo Cafe', 'THREE', 'Specialty Batch', 'BOON', 'Refill Roastery',
                'Archers Coffee', 'Café Rider', 'Fritz Coffee', 'Five Elephant',
                'NY Coffee Roastery', 'Taf', 'The Barn', 'Blacksmith', 'NOW', 'Gardelli'
            ];

            foreach ($brands as $key => $brand) {
                Brand::create([
                    'type' => 'product',
                    'name' => $brand,
                    'short_description' => $brand,
                    'description' => $brand,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }

            $brands = [
                'Kalita',
                'Chemex',
                'Acaia',
                'Hario',
                'Brewista'
            ];

            foreach ($brands as $key => $brand) {
                Brand::create([
                    'type' => 'equipment',
                    'name' => $brand,
                    'short_description' => $brand,
                    'description' => $brand,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
