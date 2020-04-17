<?php

use Illuminate\Database\Seeder;

class TransportersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transporters')->delete();
        DB::table('transporters')->insert([
            [
                'name' => 'Demo User',
                'email' => 'demo@foodie.com',
                'password' => bcrypt('123456'),
                'phone' => '+919898765654'
            ]
        ]);
    }
}
