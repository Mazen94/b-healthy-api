<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nutritionist;
use Faker\Generator as Faker;

$factory->define(Nutritionist::class, function (Faker $faker) {
    return [
        'email'=>'admin@admin.com',
        'firstName'=> $faker->firstName,
        'lastName' => $faker->lastName,
        'password' =>bcrypt('adminadmin'),


    ];
});
