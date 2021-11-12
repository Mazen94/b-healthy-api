<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ingredient;
use Faker\Generator as Faker;
use App\Models\Nutritionist;
$factory->define(
    Ingredient::class,
    function (Faker $faker) {


        return [
            'name' => $faker->unique()->name,
            'nutritionist_id' => $faker->randomElement([1,2]),
            'amount' => $faker->numberBetween(100, 100),
            'calorie' => $faker->numberBetween(100, 300)
        ];
    }
);
