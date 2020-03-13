<?php


namespace App\Repositories;

use App\Menu;
use App\MenuIngredients;
use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Support\Facades\DB;

class MenuRepository
{
    /**
     * Method for patient to create a new  menu
     *
     * @param string $name
     * @param string $type_menu
     * @param string $calorie
     * @return Menu
     */
    public function createMenu($name, $type_menu, $calorie)
    {
        $menu = new Menu();
        $menu->name = $name;
        $menu->type_menu = $type_menu;
        if (!empty($calorie)) {
            $menu->calorie = $calorie;
        }
        $menu->save();

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
            DB::table('ingredient_menu')->insert(
                [
                    'menu_id' => $menu->id,
                    'ingredient_id' => $ingredient['id'],
                    'amount' => $ingredient['pivot']['amount']
                ]
            );
        }
        return $menu->id;
    }

}
