<?php

use Illuminate\Database\Seeder;
use App\Shop;
class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->delete();
        DB::table('shops')->insert([
            [
                'name' => 'Gary danko',
                'email' => 'demo@foodie.com',
                'password' => bcrypt('123456'),
                'address' => 'Triplicane, Chennai, Tamil Nadu, India',
                'maps_address' => 'Triplicane, Chennai, Tamil Nadu, India',
                'latitude' => '13.05871070',
                'longitude' => '80.27570630',
                'estimated_delivery_time' => '30',
                'phone' => '8765654345',
                'description' => 'good resturant'
            ],
            [
                'name' => 'Mcdonald',
                'email' => 'demo2@foodie.com',
                'password' => bcrypt('123456'),
                'address' => 'Triplicane, Chennai, Tamil Nadu, India',
                'maps_address' => 'Triplicane, Chennai, Tamil Nadu, India',
                'latitude' => '13.05871070',
                'longitude' => '80.27570630',
                'estimated_delivery_time' => '30',
                'phone' => '8768884345',
                'description' => 'good resturant'
            ]
        ]);
        $Shops = Shop::all();
        foreach($Shops as $key => $Shop){
            $Shop->cuisines()->detach();
            $Shop->cuisines()->attach($key+1);   
        }
        
    }
}
