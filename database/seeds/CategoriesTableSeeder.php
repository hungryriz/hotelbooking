<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('categories')->delete();
        DB::table('categories')->insert([
            [
                'name' => 'Appetizer',
                'shop_id' => 1,
                'description' => 'special'
            ],
            [
                'name' => 'Meat and Game Birds',
                'shop_id' => 1,
                'description' => 'special'
            ],
            [
                'name' => 'Dessert',
                'shop_id' => 1,
                'description' => 'special'
            ],
            [
                'name' => 'Burgers',
                'shop_id' => 2,
                'description' => 'special'
            ],
            [
                'name' => 'Sandwitch',
                'shop_id' => 2,
                'description' => 'special'
            ],
            [
                'name' => 'Snacks',
                'shop_id' => 2,
                'description' => 'special'
            ],
        ]);
    }
}
