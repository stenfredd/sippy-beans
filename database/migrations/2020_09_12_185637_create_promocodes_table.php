<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('promocode')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('used_limit')->nullable()->unsigned();
            $table->enum('promocode_type', ['all', 'user'])->nullable()->default('all');
            $table->enum('discount_type', ['percentage', 'amount'])->nullable();
            $table->double('discount_amount', 10, 2)->nullable();
            $table->tinyInteger('one_time_user')->nullable()->default(0)->comment("0-No, 1-Yes");
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
        Schema::dropIfExists('promocodes');
    }
}
