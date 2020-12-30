<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('weight_id')->nullable()->constrained('weights');
            $table->string('grind_ids')->nullable();
            $table->string('title')->nullable();
            $table->string('sku')->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            $table->tinyInteger('is_default')->nullable()->default(0)->comment("0-Default/No, 1-Yes");
            $table->tinyInteger('reward_point')->nullable()->default(0);
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
        Schema::dropIfExists('variants');
    }
}
