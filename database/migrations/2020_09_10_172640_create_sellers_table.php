<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string("seller_name")->nullable();
            $table->text("seller_info")->nullable();
            $table->string("seller_image")->nullable();
            $table->string("seller_address")->nullable();
            $table->string("seller_phone", 50)->nullable();
            $table->string("seller_email", 50)->nullable();
            $table->tinyInteger('display_order')->nullable()->default(0);
            $table->tinyInteger("status")->nullable()->default(0)->comment("0=Inactive, 1=Active");
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
        Schema::dropIfExists('sellers');
    }
}
