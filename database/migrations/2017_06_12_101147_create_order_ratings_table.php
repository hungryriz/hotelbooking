<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('user_id')->nullable();
            $table->integer('user_rating')->nullable();
            $table->text('user_comment')->nullable();
            $table->integer('transporter_id')->nullable();
            $table->integer('transporter_rating')->nullable();
            $table->text('transporter_comment')->nullable();
            $table->integer('shop_id')->nullable();
            $table->integer('shop_rating')->nullable();
            $table->text('shop_comment')->nullable();
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
        Schema::dropIfExists('order_ratings');
    }
}
