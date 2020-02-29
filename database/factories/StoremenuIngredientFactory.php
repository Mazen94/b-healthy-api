<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StoremenuIngredient;
use Faker\Generator as Faker;
use App\Storemenu;
use App\Ingredient;
$factory->define(StoremenuIngredient::class, function (Faker $faker) {
    $storeMenu = Storemenu::all()->pluck('id')->toArray();
    $ingredient = Ingredient::all()->pluck('id')->toArray();
    return [

        'storemenu_id' =>$faker->randomElement($storeMenu),
        'ingredients_id' => $faker->randomElement($ingredient),
        'quantite' => $faker->numberBetween(50,100)
    ];
});
