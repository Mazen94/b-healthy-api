<?php

use Illuminate\Database\Seeder;
use App\Models\Nutritionist;
class NutritionnistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Nutritionist::class, 5)->create();
    }
}
