<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->string('name')->nullable();
            $table->tinyInteger('display_order')->nullable()->default(0);
            $table->double('delivery_fee', 10, 2)->nullable()->default(0);
            $table->string('delivery_time', 50)->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment('0=Default/Inactive, 1=Active');
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
        Schema::dropIfExists('cities');
    }
}
