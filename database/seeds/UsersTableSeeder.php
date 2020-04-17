<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'name' => 'Demo User',
                'email' => 'demo@foodie.com',
                'password' => bcrypt('123456'),
                'phone' => '+915454545454',
                'device_type' => 'ios',
                'login_by' => 'manual'
            ]
        ]);
    }
}
