<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Dispute Manager',
                'guard_name' => 'admin'
            ]
        ]);
        DB::table('model_has_roles')->delete();
        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_id' => 1,
                'model_type' => 'App\Admin'
            ]
        ]);
    }
}
