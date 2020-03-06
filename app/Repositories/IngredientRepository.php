<?php


namespace App\Repositories;

use App\Ingredient;

use Illuminate\Database\Eloquent\Model;

class IngredientRepository
{
    protected $model;

    /**
     * PatientRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to get all the Ingredients from database
     *
     * @return mixed
     */
    public function getAllIngredients()
    {
        return $this->model->ingredients()->paginate();
    }

    /**
     * method to get only  one Ingredient
     *
     * @param $id
     * @return mixed
     */
    public function getIngredient($id)
    {
        return $this->model->ingredients()->find($id);
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

        return $this->model->ingredients()->save($ingredient);
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
        $ingredient = $this->model->ingredients()->findOrFail($id);
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
        $ingredient = $this->model->ingredients()->findOrFail($id);
        $ingredient->nom = $request['nom'];
        $ingredient->quantite = $request['quantite'];
        $ingredient->calorie = $request['calorie'];
        $ingredient->save();
        return $ingredient;
    }
}
