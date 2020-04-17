<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryDateToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if(!Schema::hasColumn('orders', 'delivery_date'))  //check whether users table has email column
        {
            Schema::table('orders', function($table) {
                $table->dateTime('delivery_date')->nullable();
            });
        }
        if(!Schema::hasColumn('orders', 'order_otp'))  //check whether users table has email column
        {
            Schema::table('orders', function($table) {
                $table->integer('order_otp')->nullable();
            });
        }
        if(!Schema::hasColumn('shops', 'default_banner'))  //check whether users table has email column
        {
            Schema::table('shops', function($table) {
                $table->string('default_banner')->nullable();
            });
        }
        
    }

    
}
