<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        DB::table('admins')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@foodie.com',
                'password' => bcrypt('123456'),
                'phone' => '+911234565434'
            ]
        ]);
        DB::table('admins')->insert([
            [
                'name' => 'Admin1',
                'email' => 'admin1@hellodrive.uk',
                'password' => bcrypt('123456'),
                'phone' => '+911111111111'
            ]
        ]);
        DB::table('admins')->insert([
            [
                'name' => 'Admin2',
                'email' => 'admin2@hellodrive.uk',
                'password' => bcrypt('123456'),
                'phone' => '+912222222222'
            ]
        ]);
    }
}
