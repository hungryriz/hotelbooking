<?php

use Illuminate\Database\Seeder;

class ShopTimingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_timings')->delete();
        DB::table('shop_timings')->insert([
            [
                'shop_id' => '1',
                'start_time' => '08:00',
                'end_time' => '20:00',
                'day' => 'ALL',
            ],
            [
                'shop_id' => '2',
                'start_time' => '08:00',
                'end_time' => '20:00',
                'day' => 'ALL',
            ]
        ]);
    }
}
