<?php

use Illuminate\Database\Seeder;

class ProductPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_prices')->delete();
        DB::table('product_prices')->insert([
            [
                'product_id' => '1',
                'price' => '100'
            ],
            [
                'product_id' => '2',
                'price' => '100'
            ]
            ,
            [
                'product_id' => '3',
                'price' => '100'
            ],
            [
                'product_id' => '4',
                'price' => '100'
            ],
            [
                'product_id' => '5',
                'price' => '100'
            ],
            [
                'product_id' => '6',
                'price' => '100'
            ]
        ]);
    }
}
