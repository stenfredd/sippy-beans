<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['product', 'equipment', 'subscription'])->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('equipment_id')->nullable()->constrained('equipments');
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->tinyInteger('display_order')->nullable()->default(0);
            $table->string('url')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
