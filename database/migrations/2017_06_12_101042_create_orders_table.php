<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('invoice_id');
            $table->integer('user_id');
            $table->integer('shift_id')->nullable();
            $table->integer('user_address_id');
            $table->integer('shop_id')->nullable();
            $table->integer('transporter_id')->nullable();
            $table->integer('transporter_vehicle_id')->nullable();
            $table->text('reason')->nullable();
            $table->text('note')->nullable();
            $table->text('route_key');
            $table->enum('dispute', ['CREATED', 'RESOLVE','NODISPUTE'])->default('NODISPUTE');
            $table->dateTime('delivery_date');
            $table->integer('order_otp');
            $table->integer('order_ready_time')->default(0);
            $table->integer('order_ready_status')->default(0);
            $table->enum('status', [
                    'ORDERED',             // Order recieved and is waiting to be acknowledged by hotel.
                    'RECEIVED',             // Request was acknowledged by hotel.
                    'CANCELLED',            // Request was cancelled by hotel or user
                    'ASSIGNED',             // AssiTransportergn Transporter The Order
                    'PROCESSING',
                    'SEARCHING',           // Transporter has accepted the order and is processing the request
                    'REACHED',              // Transporter reached hotel and waiting for pickup
                    'PICKEDUP',             // Transporter has picked up the package and moving to delivery location
                    'ARRIVED',              // Food is at users doorstep
                    'COMPLETED',            // Order has been delivered and completed the request
                ])->default('ORDERED');

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
        Schema::dropIfExists('orders');
    }
}
