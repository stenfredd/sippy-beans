<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('address_id')->nullable()->constrained('user_addresses');
            $table->string('order_number')->nullable();
            $table->enum('order_type', ['subscription', 'product'])->nullable();

            $table->double('cart_total', 10, 2)->nullable()->default(0);
            $table->double('delivery_fee', 10, 2)->nullable()->default(0);

            $table->enum('discount_type', ['percentage', 'amount'])->nullable();
            $table->double('discount_amount', 10, 2)->nullable()->default(0);
            $table->string('promocode')->nullable();
            $table->double('promocode_amount', 10, 2)->nullable()->default(0);

            $table->double('subtotal', 10, 2)->nullable()->default(0);
            $table->double('tax_charges', 10, 2)->nullable()->default(0);

            $table->double('total_amount', 10, 2)->nullable()->default(0);
            $table->double('payment_received', 10, 2)->nullable()->default(0);

            $table->tinyInteger('payment_type')->nullable()->default(0)->comment("1-Cash on delivery, 2-Card");
            $table->enum('card_type', ['mastercard', 'visa', 'rupay'])->nullable();
            $table->string('card_number')->nullable();

            $table->integer('reward_points')->unsigned()->nullable()->default(0);
            $table->text('customer_note')->nullable();
            $table->text('internal_note')->nullable();
            $table->tinyInteger('payment_status')->nullable()->default(0)->comment("1-Pending, 2-Received, 3=Partial Refund, 4-Refund");
            $table->tinyInteger('status')->nullable()->default(0)->comment("0-New, 1-In Progress, 2=Shipped, 3-Completed, 4-Cancelled");
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
        Schema::dropIfExists('orders');
    }
}
