<?php

use Illuminate\Database\Seeder;

class DisputesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disputes')->delete();
        DB::table('disputes')->insert([
            [
                'name' => 'Demo Dispute Manager',
                'email' => 'demo@foodie.com',
                'password' => bcrypt('123456'),
                'phone' => '+912345654345'
            ]
        ]);
    }
}
