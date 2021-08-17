<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = [
            'best_for', 'brand', 'characteristic', 'coffee_flavor', 'grind', 'level',
            'origin', 'process', 'seller', 'type', 'price'
        ];
        Schema::create('match_makers', function (Blueprint $table) use ($types) {
            $table->id();
            $table->string("image_url")->nullable();
            $table->string("question")->nullable();
            $table->enum('type', $types)->nullable();
            $table->tinyInteger('min_select')->nullable()->default(0);
            $table->tinyInteger('max_select')->nullable()->default(0);
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
        Schema::dropIfExists('match_markers');
    }
}
