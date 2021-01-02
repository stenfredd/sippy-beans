<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(BestforSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(BrandTypeSeeder::class);
        $this->call(CharacteristicSeeder::class);
        $this->call(CoffeeFlavourSeeder::class);
        $this->call(CoffeeTypesSeeder::class);
        $this->call(GrindSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(OriginSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(ProcessSeeder::class);
        $this->call(SellersSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(TaxClassesSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(WeightSeeder::class);

        $this->call(EquipmentsSeeder::class);
        $this->call(MatchMakerSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(PriceSeeder::class);
        $this->call(ProductsSeeder::class);
    }
}
