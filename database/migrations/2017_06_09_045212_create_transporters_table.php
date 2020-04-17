<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->text('address')->nullable();
            $table->double('latitude', 15, 8)->default(0);
            $table->double('longitude', 15, 8)->default(0);
            $table->string('otp')->default(0);
            $table->integer('rating')->default(5);
            $table->string('device_token')->nullable();
            $table->string('device_id')->nullable();
            $table->enum('device_type',array('android','ios'))->nullable();
            $table->enum('status', [
                    'assessing',
                    'banned',
                    'online',
                    'offline',
                    'riding',
                    'unsettled'
                ])->default('assessing');

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
        Schema::drop('transporters');
    }
}
