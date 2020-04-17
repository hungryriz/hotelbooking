<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('avatar')->nullable();
            $table->string('default_banner')->nullable();
            $table->string('description')->nullable();
            $table->double('offer_min_amount',20, 2)->default(0)->nullable();
            $table->integer('offer_percent')->nullable()->default(0); 
            $table->integer('estimated_delivery_time')->nullable();
            $table->integer('otp')->nullable();
            $table->string('address');
            $table->string('maps_address');
            $table->double('latitude', 15, 8);
            $table->double('longitude', 15, 8);
            $table->boolean('pure_veg')->default(0)->nullable();
            $table->boolean('popular')->default(0)->nullable();
            $table->integer('rating')->nullable()->default(0);
            $table->integer('rating_status')->default(0);
            $table->enum('status', [
                    'onboarding',
                    'banned',
                    'active',
                ])->default('onboarding');
            $table->enum('device_type', [
                    'ios',
                    'android'
                ]);
            $table->text('device_token')->nullable();
            $table->string('device_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shops');
    }
}
