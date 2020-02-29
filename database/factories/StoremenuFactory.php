<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Storemenu;
use Faker\Generator as Faker;

$factory->define(Storemenu::class, function (Faker $faker) {
    return [
        'nom' => $faker->unique()->name,
        'max_age' => $faker->numberBetween(30,50),
        'min_age' => $faker->numberBetween(15,20),
        'calorie'=> $faker->numberBetween(1200,2000),
        'type_menu' => $faker->randomElement(['petit déjeuner ','dejeuner','dinner','collation1','collations2']),
        'nutritionist_id' => 1
    ];
});
