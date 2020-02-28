<?php

use Illuminate\Database\Seeder;
use App\Nutritionist;
class NutritionnistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Nutritionist::class, 2)->create();
    }
}
