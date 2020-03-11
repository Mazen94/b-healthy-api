<?php


namespace App\Repositories;

use App\Ingredient;
use App\Nutritionist;
use Illuminate\Database\Eloquent\Model;


class IngredientRepository
{
    protected $nutritionist;

    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }
    /**
     * Method to create a new Ingredient related to nutritionist
     *
     * @param $name
     * @param $amount
     * @param $calorie
     * @return false|Model
     */
    public function createIngredient($name, $amount, $calorie)
    {
        $ingredient = new Ingredient();
        $ingredient->name = $name;
        $ingredient->amount = $amount;
        $ingredient->calorie = $calorie;
        return $this->nutritionist->ingredients()->save($ingredient);
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
     * @param $amount
     * @param $calorie
     * @param Ingredient $ingredient
     * @return Ingredient $ingredient
     */
    public static function updateIngredient($name, $amount, $calorie, $ingredient)
    {
        $ingredient->name = $name;
        $ingredient->amount = $amount;
        $ingredient->calorie = $calorie;
        $ingredient->save();
        return $ingredient;
    }
}
