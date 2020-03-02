<?php


namespace App\Repositories;

use App\Ingredient;
use App\Nutritionist;

class IngredientRepository
{
    protected $nutritionist;

    /**
     * PatientRepository constructor.
     * @param Nutritionist $nutritionist
     */
    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * Method to get all the Ingredients from database
     *
     * @return mixed
     */
    public function getAllIngredients()
    {
        return $this->nutritionist->ingredients()->get();
    }

    /**
     * method to get only  one Ingredient
     *
     * @param $id
     * @return mixed
     */
    public function getIngredient($id)
    {
        return $this->nutritionist->ingredients()->find($id);
    }

    /**
     * Method to create a new Ingredient
     *
     * @param $request
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createIngredient($data)
    {
        $ingredient = new Ingredient();
        $ingredient->nom = $data->nom;
        $ingredient->quantite = $data->quantite;
        $ingredient->calorie = $data->calorie;

        return $this->nutritionist->ingredients()->save($ingredient);
    }

    /**
     * Method to delete Ingredient
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteIngredient($id)
    {
        $ingredient = $this->nutritionist->ingredients()->findOrFail($id);
        return $ingredient->delete();
    }

    /**
     * Method to update ingredient
     *
     * @param $request
     * @param $res
     * @return bool|false|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasMany[]
     */
    public function updateIngredient($request, $id)
    {
        $ingredient = $this->nutritionist->ingredients()->findOrFail($id);
        if ($ingredient) {
            return $ingredient->fill($request->all())->save();
        }
    }
}
