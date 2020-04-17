<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');

            $table->integer('quantity');
            $table->integer('paid')->default(0);
            $table->double('gross',10,2)->default(0);
            $table->double('discount',10,2)->default(0);    // Discount => (Percentage) = (Gross * Discount / 100)
            $table->double('delivery_charge',10,2)->default(0);  // Discount => (Amount)     = (Gross - Discount)
            $table->double('wallet_amount',10,2)->default(0);
            $table->integer('payable')->default(0);
            $table->double('tax',10,2)->default(0);                     // Tax = (Gross - Discount) * Tax / 100
            $table->integer('net')->default(0);                     // Net = Gross - Discount + Tax
            $table->double('total_pay')->default(0);
            $table->double('tender_pay')->default(0); 
            $table->string('ripple_price')->nullable();         
            $table->enum('payment_mode', [
                    'cash',
                    'stripe',
                    'paypal',
                    'braintree',
                    'wallet',
                    'ripple',
                    'eather',
                    'bitcoin'
                ])->default('cash');
            $table->text('DestinationTag')->nullable();
            $table->text('payment_id')->nullable();
            $table->enum('status', [
                    'pending',
                    'processing',
                    'failed',
                    'success',
                ])->default('pending');

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
        Schema::dropIfExists('order_invoices');
    }
}
