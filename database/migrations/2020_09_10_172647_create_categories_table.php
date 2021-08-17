<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_title')->nullable();
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->tinyInteger('display_order')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->comment("0-Inactive/Default, 1=Active")->nullable();
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
        Schema::dropIfExists('categories');
    }
}
