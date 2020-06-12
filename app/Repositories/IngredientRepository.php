<?php


namespace App\Repositories;

use App\Ingredient;
use App\MealStore;
use Illuminate\Database\Eloquent\Model;

class IngredientRepository
{
    protected $ingredient;

    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    /**
     * Method to delete Ingredient
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function deleteIngredient()
    {
        return $this->ingredient->delete();
    }

    /**
     * Method to update ingredient
     *
     * @param $name
     * @param $amount
     * @param $calorie
     *
     * @return Ingredient
     */
    public function updateIngredient($name, $amount, $calorie)
    {
        $this->ingredient->name = $name;
        $this->ingredient->amount = $amount;
        $this->ingredient->calorie = $calorie;
        $this->ingredient->save();
        return $this->ingredient;
    }

    /**
     * update amount ingredient to a storeMenu
     *
     * @param string $amount
     * @param MealStore $mealStore
     * @param $mealStoreCalorie
     * @return bool|mixed|null
     */
    public function updateAmountIngredientInMealStore($amount,$mealStore,$mealStoreCalorie)
    {
        $mealStore->calorie = $mealStoreCalorie;
        $mealStore->save();
        $this->ingredient->pivot->amount = $amount;
        $this->ingredient->pivot->save();
        $mealStore['ingredients'] = $mealStore->ingredients;
        return $mealStore;
    }
}
