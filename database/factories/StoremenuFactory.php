<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MealStore;
use Faker\Generator as Faker;

$factory->define(MealStore::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'max_age' => $faker->numberBetween(30,50),
        'min_age' => $faker->numberBetween(15,20),
        'calorie'=> $faker->numberBetween(1200,2000),
        'type_menu' => $faker->randomElement([0,1,2,3,4]),
        'nutritionist_id' => $faker->randomElement([1,2]),
    ];
});
