<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporterShiftTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporter_shift_timings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transporter_shift_id');
            $table->string('start_time');
            $table->string('end_time')->nullable();;
             $table->integer('order_count')->default(0);
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
        Schema::dropIfExists('transporter_shift_timings');
    }
}
