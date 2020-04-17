<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('shop_id');
            $table->string('name');
            $table->text('description');
            $table->integer('position')->nullable();
            $table->enum('food_type',['veg','non-veg'])->default('veg');
            $table->boolean('avalability')->default('0');
            $table->integer('max_quantity')->default('10');
            $table->integer('featured')->default(0);
            $table->integer('addon_status')->default(0);
            $table->enum('out_of_stock', [
                    'YES',
                    'NO'
                ])->default('NO');
            $table->enum('status', [
                    'enabled',
                    'disabled'
                ])->default('enabled');

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
        Schema::dropIfExists('products');
    }
}
