<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporterShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporter_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transporter_id');
            $table->integer('transporter_vehicle_id');
            $table->integer('total_order')->default(0);
            $table->string('start_time');
            $table->string('end_time')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transporter_shifts');
    }
}
