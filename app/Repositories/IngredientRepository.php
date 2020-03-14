<?php


namespace App\Repositories;

use App\Ingredient;
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
     * @return Model
     */
    public function updateIngredient($name, $amount, $calorie)
    {
        $this->ingredient->name = $name;
        $this->ingredient->amount = $amount;
        $this->ingredient->calorie = $calorie;
        $this->ingredient->save();
        return $this->ingredient;
    }
}
