<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id')->nullable()->index();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('name', 200)->nullable();
            $table->string('profile_image', 200)->nullable();
            $table->string('email')->unique();
            $table->string('country_code', 20)->nullable();
            $table->string('phone')->unique()->nullable();
            $table->tinyInteger('device_type')->nullable()->default(0)->comment("0=Default, 1=Android, 2=IOS");
            $table->string('device_token', 255)->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->tinyInteger('social_login')->nullable()->default(0)->comment("0=Default, 1=Apple, 2=Google");
            $table->string('apple_id', 100)->nullable();
            $table->string('google_id', 100)->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment("0=Default, 1=Active, 2=Unverified, 3=Blocked");
            $table->enum('user_type', ['admin', 'user'])->nullable()->default('user');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
