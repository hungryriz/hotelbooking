<?php

use Illuminate\Database\Seeder;

class CuisinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cuisines')->delete();
        DB::table('cuisines')->insert([
            [
                'name' => 'INDIAN'
            ],
            [
                'name' => 'SOUTH INDIAN'
            ],
            [
                'name' => 'BENGOLI'
            ],
        ]);
    }
}
