<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->text('description')->nullable();
            $table->string('varietal', 255)->nullable();
            $table->string('altitude', 255)->nullable();
            $table->string('sku', 255)->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->string('flavor_note', 255)->nullable()->default(0);
            $table->string('tags', 255)->nullable();
            $table->string('commission_fee', 20)->nullable();
            $table->string('commission_type', 20)->nullable();

            $table->foreignId('type_id')->nullable()->constrained('types');
            $table->foreignId('origin_id')->nullable()->constrained('origins');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('brand_type_id')->nullable()->constrained('brand_types');
            $table->foreignId('characteristic_id')->nullable()->constrained('characteristics');
            $table->foreignId('best_for_id')->nullable()->constrained('best_fors');
            $table->foreignId('coffee_type_id')->nullable()->constrained('coffee_types');
            $table->foreignId('level_id')->nullable()->constrained('levels');
            $table->foreignId('process_id')->nullable()->constrained('processes');
            $table->foreignId('seller_id')->nullable()->constrained('sellers');
            $table->foreignId('tax_class_id')->nullable()->constrained('tax_classes');
            $table->foreignId('category_id')->nullable()->constrained('categories');

            $table->tinyInteger('grind_type')->nullable()->default(0)->comment("1-All, 2=Custom");
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
        Schema::dropIfExists('products');
    }
}
