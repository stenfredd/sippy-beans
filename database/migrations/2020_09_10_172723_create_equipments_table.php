<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->tinyInteger('reward_point')->nullable()->default(0);
            $table->tinyInteger('quantity')->nullable()->default(0);
            $table->string('weight')->nullable();
            $table->string('tags')->nullable();
            $table->string('commission_fee', 20)->nullable();
            $table->string('commission_type', 20)->nullable();

            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('type_id')->nullable()->constrained('types');
            $table->foreignId('seller_id')->nullable()->constrained('sellers');
            $table->foreignId('tax_class_id')->nullable()->constrained('tax_classes');
            $table->foreignId('roster_type_id')->nullable()->constrained('coffee_types');
            $table->foreignId('category_id')->nullable()->constrained('categories');

            $table->tinyInteger('display_order')->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->default(0)->comment("0-Default/Inactive, 1-Active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
}
