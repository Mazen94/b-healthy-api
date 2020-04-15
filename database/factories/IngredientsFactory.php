<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ingredient;
use Faker\Generator as Faker;
use App\Nutritionist;
$factory->define(
    Ingredient::class,
    function (Faker $faker) {
        $users = Nutritionist::all()->pluck('id')->toArray();

        return [
            'name' => $faker->unique()->name,
            'nutritionist_id' => $faker->randomElement($users),
            'amount' => $faker->numberBetween(100, 100),
            'calorie' => $faker->numberBetween(100, 300)
        ];
    }
);
