<?php


namespace App\Repositories;

use App\Recommendation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecommendationRepository
{
    protected $recommendation;

    public function __construct(Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
    }


    /**
     * Method for nutritionist to update recommendation related to patient
     *
     *
     * @param String $name
     * @param string $avoid
     *
     * @return false|Model
     */
    public function updateRecommendation($name, $avoid)
    {
        $this->recommendation->avoid = $avoid;
        $this->recommendation->name = $name;
        $this->recommendation->save();
        return $this->recommendation;
    }

    /**
     * Method for nutritionist to delete recommendation related to patient
     *
     *
     * @throws \Exception
     */
    public function deleteRecommendation()
    {
        $this->recommendation->delete();
    }

    /**
     * Method to add menu to recommendation related to patient
     *
     *
     * @param  $mealStore
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function addMenuToRecommendation($mealStore)
    {
        $name = $mealStore->name;
        $calorie = $mealStore->calorie;
        $typeMenu = $mealStore->type_menu;
        $ingredients = $mealStore->ingredients;
        $idMenu = MenuRepository::createMenuWithIngredients($name, $calorie, $typeMenu, $ingredients);
        $this->recommendation->menus()->attach($idMenu);
        return $this->recommendation->menus;
    }


    /**
     * Method  to detach menu related to patient
     *
     *
     * @param $idMenu
     * @return mixed
     */
    public function destroyMenu($idMenu)
    {
        return $this->recommendation->menus()->detach($idMenu);
    }

    public function checkTypeMenuExist($typeMenu)
    {
        return $this->recommendation->menus()->where('type_menu', $typeMenu)->get();
    }
}
