<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(NutritionnistTableSeeder::class);
        $this->call(IngredientsTableSeeder::class);
        $this->call(StoremenuTableSeeder::class);
        $this->call(StoremenuIngredientTableSeeder::class);
        $this->call(PatientTableSeeder::class);
    }
}
