<?php


namespace App\Repositories;


use App\Ingredient;
use App\Menu;
use App\Nutritionist;
use App\Storemenu;
use App\StoremenuIngredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class StoreMenuRepository
{

    /**
     * method to get only one StoreMenu with the ingredients related to nutritionist
     * @param Nutritionist $nutritionist
     * @param int $age
     * @return Collection
     */
    public static function getStoreMenuWithIngredientsByAge($nutritionist, $age)
    {
        return $nutritionist->storemenus()
            ->where('min_age', '<=', $age)
            ->where('max_age', '>=', $age)
            ->get();
    }

    /**
     * Method to create a new store menu related to nutritionist
     *
     * @param Nutritionist $nutritionist
     *
     * @param string $name
     * @param int $max_age
     * @param int $min_age
     * @param int $calorie
     * @param string $type_menu
     * @return false|Model
     */
    public static function createStoreMenu($nutritionist, $name, $max_age, $calorie, $min_age, $type_menu)
    {
        $menu = new Storemenu();
        $menu->name = $name;
        $menu->max_age = $max_age;
        $menu->min_age = $min_age;
        $menu->type_menu = $type_menu;
        if (!empty($calorie)) {
            $menu->calorie = $calorie;
        }
        return $nutritionist->storemenus()->save($menu);
    }

    /**
     * Method to update storeMenu related to nutritionist
     *
     * @param Storemenu $storeMenu
     * @param string $name
     * @param int $max_age
     * @param int $calorie
     * @param int $min_age
     * @param string $type_menu
     * @return bool|false|Collection|Model|HasMany|HasMany[]
     */
    public static function updateStoreMenu($storeMenu, $name, $max_age, $calorie, $min_age, $type_menu)
    {
        $storeMenu->name = $name;
        $storeMenu->max_age = $max_age;
        $storeMenu->min_age = $min_age;
        $storeMenu->type_menu = $type_menu;
        if (!empty($calorie)) {
            $storeMenu->calorie = $calorie;
        }
        $storeMenu->save();
        return $storeMenu;
    }

    /**
     * Method to delete storeMenu related to nutritionist
     *
     * @param Storemenu $storeMenu
     * @return bool|mixed|null
     *
     * @throws \Exception
     */
    public static function deleteStoreMenu($storeMenu)
    {
        return $storeMenu->delete();
    }

    /**
     * Add ingredient to a storeMenu related to nutritionist
     *
     * @param int $storeMenu_id
     * @param int $ingredients_id
     * @param int $amount
     * @return bool|mixed|null
     */
    public static function addIngredientToStoreMenu($storeMenu_id, $ingredients_id, $amount)
    {
        $storeMenu = new StoremenuIngredient();
        $storeMenu->storemenu_id = $storeMenu_id;
        $storeMenu->ingredients_id = $ingredients_id;
        $storeMenu->amount = $amount;
        $storeMenu->save();
        return $storeMenu;
    }

    /**
     * Method for nutritionist to delete ingredient to the storeMenu.
     *
     * @param Menu $menu
     * @param int $id_ingredient
     * @return bool|mixed|null
     * @throws \Exception
     */
    public static function deleteIngredientToStoreMenu($menu, $id_ingredient)
    {
        return $menu->ingredients()->detach($id_ingredient);
    }

    /**
     * update amount ingredient to a storeMenu
     *
     * @param Ingredient $ingredient
     * @param string $amount
     * @return bool|mixed|null
     * @throws \Exception
     */
    public static function updateAmountIngredientInStoreMenu($ingredient, $amount)
    {
        $ingredient->pivot->amount = $amount;
        $ingredient->pivot->save();
        return $ingredient->pivot;
    }

}
