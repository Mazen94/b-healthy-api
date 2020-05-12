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
    public function createMenu($name, $type_menu, $calorie, $recommendation)
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

}
