<?php


namespace App\Repositories;


use App\Menu;
use App\MenuIngredients;
use Illuminate\Database\Eloquent\Model;
use Config;

class MenuRepository
{
    protected $model;

    /**
     * RecommandationRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to create a new  menu
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createMenu($request, $id_recommendation)
    {
        //TODO change $request
        $recommendation = $this->model->recommandations()->findOrFail($id_recommendation);
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->type_menu = $request->type_menu;
        $menu->posted_by = Config::get('constants.POSTED_BY_PATIENT');
        $menu->save();
        $recommendation->menus()->attach($menu->id);
        return $recommendation->menus()->findOrFail($menu->id);
    }

    /**
     * Method to create a menu with these ingredients
     * @param string $name
     * @param int $calorie
     * @param string $type_menu
     * @param array $ingredients
     * @return int id
     */
    public static function createMenuWithIngredients($name, $calorie, $type_menu, $ingredients)
    {
        $menu = new Menu();
        $menu->name = $name;
        $menu->calorie = $calorie;
        $menu->type_menu = $type_menu;
        $menu->save();
        // linked the ingredients with the menus in the table pivot menus_ingredients
        foreach ($ingredients as $ingredient) {
            $menuIngredients = new MenuIngredients();
            $menuIngredients->menu_id = $menu->id;
            $menuIngredients->ingredients_id = $ingredient['id'];
            $menuIngredients->amount = $ingredient['pivot']['amount'];
            $menuIngredients->save();
        }
        return $menu->id;
    }

}
