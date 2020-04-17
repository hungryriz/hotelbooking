<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();
        DB::table('products')->insert([
            [
                'name' => 'Crispy farm egg gribs',
                'shop_id' => 1,
                'description' => 'special'
            ],
            [
                'name' => 'Coconut thai curry with shirump',
                'shop_id' => 1,
                'description' => 'special'
            ],
            [
                'name' => 'Baked choclate shuffle',
                'shop_id' => 1,
                'description' => 'special'
            ],
            [
                'name' => 'Big mac',
                'shop_id' => 2,
                'description' => 'special'
            ],
            [
                'name' => 'Chicken Sandwitch',
                'shop_id' => 2,
                'description' => 'special'
            ],
            [
                'name' => 'Apple slice',
                'shop_id' => 2,
                'description' => 'special'
            ],
        ]);
        $Products = Product::all();
        foreach($Products as $key => $Product){
             $Product->categories()->detach();
             $Product->categories()->attach($key+1);   
        }
    }
}
