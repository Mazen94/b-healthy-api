<?php

use Illuminate\Database\Seeder;

class StoremenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\MealStore::class,20)->create();
    }
}
