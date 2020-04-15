<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nutritionist;
use Faker\Generator as Faker;

$factory->define(Nutritionist::class, function (Faker $faker) {
    return [
        'nom' => $faker->unique()->name,
        'email'=>'admin@admin.com',
        'password' =>bcrypt('adminadmin'),
        'lastName' => $faker->lastName,
        'firstName'=> $faker->firstName,
        'gender' => $faker->randomElement(['male','female']),
        'picture' => $faker->imageUrl(),


    ];
});
