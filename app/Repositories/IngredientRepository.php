<?php


namespace App\Repositories;

use App\Ingredient;
use App\Nutritionist;


class IngredientRepository
{

    /**
     * Method to create a new Ingredient related to nutritionist
     *
     * @param Nutritionist $nutritionist
     * @param $name
     * @param $amount
     * @param $calorie
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public static function createIngredient($nutritionist, $name, $amount, $calorie)
    {
        $ingredient = new Ingredient();
        $ingredient->name = $name;
        $ingredient->amount = $amount;
        $ingredient->calorie = $calorie;
        return $nutritionist->ingredients()->save($ingredient);
    }

    /**
     * Method to delete Ingredient
     *
     * @param Ingredient $ingredient
     * @return bool
     *
     * @throws \Exception
     */
    public static function deleteIngredient($ingredient)
    {
        return $ingredient->delete();
    }

    /**
     * Method to update ingredient
     *
     * @param $name
     * @param $quantite
     * @param $calorie
     * @param Ingredient $ingredient
     * @return Ingredient $ingredient
     */
    public static function updateIngredient($name, $quantite, $calorie, $ingredient)
    {
        $ingredient->name = $name;
        $ingredient->quantite = $quantite;
        $ingredient->calorie = $calorie;
        $ingredient->save();
        return $ingredient;
    }
}
