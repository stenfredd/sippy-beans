<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions');
            $table->string('stripe_subscription_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->enum('payment_type', ['payment', 'refund'])->nullable()->default('payment');
            $table->enum('type', ['card', 'cash'])->nullable()->default('card');
            $table->double('amount', 10, 2)->nullable()->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
