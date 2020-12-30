<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->string('stripe_subscription_id')->nullable();
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('variant_id')->nullable()->constrained('variants');
            $table->foreignId('grind_id')->nullable()->constrained('grinds');
            $table->foreignId('equipment_id')->nullable()->constrained('equipments');
            $table->integer('quantity')->default(0)->unsigned()->nullable();
            $table->double('amount', 10, 2)->default(0)->nullable();
            $table->double('subtotal', 10, 2)->default(0)->nullable();
            $table->tinyInteger('is_cancelled')->default(0)->nullable()->comment("0=No, 1=Yes");
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
        Schema::dropIfExists('order_details');
    }
}
