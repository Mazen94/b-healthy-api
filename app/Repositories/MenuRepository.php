<?php


namespace App\Repositories;

use App\IngredientMenu;
use App\Menu;
use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Support\Facades\DB;

class MenuRepository
{

    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Method for patient to create a new  menu
     *
     * @param string $name
     * @param string $type_menu
     * @param string $calorie
     * @param $recommendation
     * @return Menu
     * @throws \Exception
     */
    public static function createMenu($name, $type_menu, $calorie, $recommendation)
    {
        $menu = new Menu();
        $menu->name = $name;
        $menu->type_menu = $type_menu;
        if (!empty($calorie)) {
            $menu->calorie = $calorie;
        }
        $menu->save();

        //Add menu to recommendation
        $recommendation->menus()->attach($menu->id);

        return $menu;
    }

    /**
     * Method for nutritionist to create a menu with these ingredients
     * @param string $name
     * @param int $calorie
     * @param string $type_menu
     * @param array $ingredients
     * @return int id
     */
    public function createMenuWithIngredients($name, $calorie, $type_menu, $ingredients)
    {
        $menu = new Menu();
        $menu->name = $name;
        $menu->calorie = $calorie;
        $menu->type_menu = $type_menu;
        $menu->save();
        // linked the ingredients with the menus in the table pivot menus_ingredients
        foreach ($ingredients as $ingredient) {
            $ingredientMenu = new IngredientMenu();
            $ingredientMenu->menu_id = $menu->id;
            $ingredientMenu->ingredient_id = $ingredient['id'];
            $ingredientMenu->amount = $ingredient['pivot']['amount'];
            $ingredientMenu->save();
        }
        return $menu->id;
    }

    /**
     * @param int $idMenu
     * @param int $caloriesOfMenu
     * @param int $idIngredient
     * @param int $amount
     * @return Menu
     */
    public function addIngredientToMenu($idMenu, $caloriesOfMenu, $idIngredient, $amount)
    {
        $this->menu->calorie = $caloriesOfMenu;
        $this->menu->save();
        $ingredientMenu = new IngredientMenu();
        $ingredientMenu->ingredient_id = $idIngredient;
        $ingredientMenu->menu_id = $idMenu;
        $ingredientMenu->amount = $amount;
        $ingredientMenu->save();
        return $this->menu;
    }

    /**
     * Check if the patient created a new menu with a special menu type today
     * @param int $typeMenu
     * @return bool
     */
    public static function checkMenuByDateMenuType($typeMenu)
    {
        $typeMenuOfPatient = self::getTypeMenuRelatedToPatient($typeMenu);
        $menuCreate = Menu::whereDate('created_at', date("Y-m-d"))->where('type_menu', $typeMenuOfPatient)->get();
        if ($menuCreate->isEmpty()) {
            $check = false;
        } else {
            $check = true;
        }

        return $check;
    }

    /**
     * Function return the value of type menu related to patient
     * @param  int $value
     * @return int
     */
    public static function getTypeMenuRelatedToPatient($value)
    {
        switch ($value) {
            case 0 :
                return 5;
            case 1 :
                return 6;
            case 2 :
                return 7;
            case 3 :
                return 8;
            case 4 :
                return 9;
        }
    }
}
