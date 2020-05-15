<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use App\Nutritionist;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    $users = Nutritionist::all()->pluck('id')->toArray();
    return [
        'email' => $faker->unique()->safeEmail,
        'password' =>bcrypt('test'), // test
        'lastName' => $faker->lastName,
        'firstName'=> $faker->firstName,
        'gender' => $faker->randomElement([0,1]),
        'profession' => $faker->randomElement(['ingenieur','joueur']),
        'age'=> $faker->numberBetween(5, 60),
        'nutritionist_id' =>  $faker->randomElement($users),
        'numberPhone' => $faker->phoneNumber


    ];
});
