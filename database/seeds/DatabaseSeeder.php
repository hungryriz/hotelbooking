<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$this->call(AdminsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CuisinesTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(TransportersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ShopTimingsTableSeeder::class);
        $this->call(ProductPricesTableSeeder::class);
        $this->call(RolesTableSeeder::class);      
    }
}
