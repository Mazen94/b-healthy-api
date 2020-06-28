<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IngredientMealStore;
use Faker\Generator as Faker;
use App\MealStore;
use App\Ingredient;

$factory->define(
    IngredientMealStore::class,
    function (Faker $faker) {
        $storeMenu = MealStore::all()->pluck('id')->toArray();
        $ingredient = Ingredient::all()->pluck('id')->toArray();
        return [
            'meal_store_id' => $faker->randomElement($storeMenu),
            'ingredient_id' => $faker->randomElement($ingredient),
            'amount' => $faker->numberBetween(50, 100)
        ];
    }
);
