<?php

use Illuminate\Database\Seeder;

class StoremenuIngredientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\IngredientMealStore::class,80)->create();
    }
}
