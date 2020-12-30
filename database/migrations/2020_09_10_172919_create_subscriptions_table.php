<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id')->nullable();
            $table->string('price_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('grind_ids')->nullable();
            $table->string('image_url')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->double('price', 10, 2)->nullable();
            $table->enum('type', ['monthly', 'yearly'])->nullable()->default('monthly');
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
        Schema::dropIfExists('subscriptions');
    }
}
