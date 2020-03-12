<?php


namespace App\Repositories;

use App\Ingredient;
use Illuminate\Database\Eloquent\Model;

class IngredientRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
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
        return $this->model->ingredients()->save($ingredient);
    }

    /**
     * Method to delete Ingredient
     *
     * @param Ingredient $ingredient
     * @return bool
     *
     * @throws \Exception
     */
    public function deleteIngredient()
    {
        return $this->model->delete();
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
        $this->model->name = $name;
        $this->model->amount = $amount;
        $this->model->calorie = $calorie;
        $this->model->save();
        return $this->model;
    }
}
