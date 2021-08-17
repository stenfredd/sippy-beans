<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedeemPromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem_promocodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->string('promocode')->nullable();
            $table->enum('type', ['percentage', 'amount'])->nullable();
            $table->double('promocode_amount', 10, 2)->nullable()->default(0);
            $table->double('redeem_amount', 10, 2)->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->default(0)->comment('0=Default, 1=Redeem');
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
        Schema::dropIfExists('redeem_promocodes');
    }
}
