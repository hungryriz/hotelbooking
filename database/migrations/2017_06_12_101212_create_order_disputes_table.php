<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_disputes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('order_disputehelp_id')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('transporter_id')->nullable();
            $table->integer('shop_id')->nullable();
            $table->enum('type',['CANCELLED', 'COMPLAINED', 'REFUND', 'REASSIGN']);
            $table->enum('created_by',[
                'user', 'shop', 'transporter'
                ]);
            $table->enum('created_to',[
                'user', 'shop', 'transporter','dispatcher'
                ]);
            $table->enum('status',[
                'CREATED', 'RESOLVED'
                ]);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('order_disputes');
    }
}
