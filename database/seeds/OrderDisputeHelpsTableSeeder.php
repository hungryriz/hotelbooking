<?php

use Illuminate\Database\Seeder;

class OrderDisputeHelpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_dispute_helps')->delete();
        DB::table('order_dispute_helps')->insert([
            [
                'name' => 'Items delayed from restaurant',
                'type' => 'COMPLAINED'
            ],
            [
                'name' => 'Items delayed of packaging',
                'type' => 'COMPLAINED'
            ],
            [
                'name' => 'Items updation late',
                'type' => 'COMPLAINED'
            ],
            [
                'name' => 'Others',
                'type' => 'COMPLAINED'
            ],
        ]);
    }
}
