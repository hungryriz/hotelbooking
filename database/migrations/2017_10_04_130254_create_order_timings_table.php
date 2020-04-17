<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_timings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->enum('status', [
                    'ORDERED',             // Order recieved and is waiting to be acknowledged by hotel.
                    'RECEIVED',             // Request was acknowledged by hotel.
                    'CANCELLED',            // Request was cancelled by hotel or user
                    'ASSIGNED',             // AssiTransportergn Transporter The Order
                    'PROCESSING',           // Transporter has accepted the order and is processing the request
                    'REACHED',              // Transporter reached hotel and waiting for pickup
                    'PICKEDUP',             // Transporter has picked up the package and moving to delivery location
                    'ARRIVED',              // Food is at users doorstep
                    'COMPLETED',
                    'SEARCHING',            // Order has been delivered and completed the request
                ])->nullable();
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
        Schema::dropIfExists('order_timings');
    }
}
