<?php


namespace App\Repositories;


use App\Menu;
use App\MenuIngredients;

use App\Recommandation;
use Illuminate\Database\Eloquent\Model;


class RecommandationRepository
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
     * Nutritionist : Method to get all the recommandations related to patient from database
     *
     * @return mixed
     */
    public   function getAllRecommendations($id)
    {
        $patient = $this->model->patients()->findOrFail($id);
        return $patient->recommandations;
    }

    /**
     * Nutritionist : method to get only one recommendation related to patient
     * @param $id
     * @return array $data;
     */
    public function getRecommendation($patient_id, $id_recommendation)
    {
        $patient = $this->model->patients()->findOrFail($patient_id);
        return $patient->recommandations()->findOrFail($id_recommendation);
    }

    /**
     *Nutritionist :  Method to create a new recommendation related to patient
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createRecommendation($request, $id_patient)
    {
        $patient = $this->model->patients()->findOrFail($id_patient);
        $rec = new Recommandation();
        $rec->avoid = $request['avoid'];
        $rec->save();
        $patient->recommandations()->attach($rec->id);
        return $rec;
    }

    /**
     * Nutritionist :  Method to update recommendation related to patient
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function updateRecommendation($request, $id_patient, $id_recommendation)
    {
        $patient = $this->model->patients()->findOrFail($id_patient);
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        $recommendation->avoid = $request['avoid'];
        $recommendation->save();

        return $recommendation;
    }

    /**
     * Nutritionist :  Method to delete recommendation related to patient
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteRecommendation($patient_id, $id_recommendation)
    {
        $patient = $this->model->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        return $recommendation->delete();
    }

    /**
     * Nutritionist :  Method to delete recommendation related to patient
     *
     * @param $patient_id
     * @param $request
     * @param $id_recommendation
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function storeMenu($request, $patient_id, $id_recommendation)
    {
        $patient = $this->model->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        // Create new menu
        $menu = new Menu();
        $menu->nom = $request['Storemenu.nom'];
        $menu->max_age = $request['Storemenu.max_age'];
        $menu->min_age = $request['Storemenu.min_age'];
        $menu->calorie = $request['Storemenu.calorie'];
        $menu->type_menu = $request['Storemenu.type_menu'];
        $menu->save();
        // Get ingredients sent in request
        $ingredients = $request['Storemenu.ingredients'];

        // linked the ingredients with the menus in the table pivot menus_ingredients
        foreach ($ingredients as $ingredient) {
            $menuIngredients = new MenuIngredients();
            $menuIngredients->menu_id = $menu->id;
            $menuIngredients->ingredients_id = $ingredient['id'];
            $menuIngredients->amount = $ingredient['pivot']['amount'];
            $menuIngredients->save();
        }
        //linked the menu with the recommendation in the table pivot menus_recommandations
        $recommendation->menus()->attach($menu->id);

        return $recommendation;
    }

    /**
     *  Nutritionist : Destroy menu related to patient
     * @param $patient_id
     * @param $id_recommendation
     * @param $id_menu
     * @return mixed
     */
    public function destroyMenu($patient_id, $id_recommendation, $id_menu)
    {
        $patient = $this->model->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        $menu = $recommendation->menus()->findOrFail($id_menu);
        return $recommendation->menus()->detach($id_menu);
    }

    /**
     *  Patient : Get the last recommendation
     * @return mixed
     */
    public function getRecommendationByPatient()
    {
       return  $this->model->recommandations()->latest("updated_at")->first();
    }

    /**
     *  Patient : Get the list of menus linked to a recommendation
     * @return mixed
     */
    public function getRecommendationMenusByPatient()
    {
        $recommendation =   $this->model->recommandations()->latest("updated_at")->first();
        return $recommendation->menus ;
    }
}
