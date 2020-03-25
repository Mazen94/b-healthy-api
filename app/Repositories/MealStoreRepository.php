<?php


namespace App\Repositories;

use App\MealStore;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;


class MealStoreRepository
{
    protected $mealStore;

    public function __construct(MealStore $mealStore)
    {
        $this->mealStore = $mealStore;
    }

    /**
     * Method to update storeMenu related to nutritionist
     *
     * @param string $name
     * @param int $maxAge
     * @param int $calorie
     * @param int $minAge
     * @param string $typeMenu
     * @return bool|false|Collection|Model|HasMany|HasMany[]
     */
    public function updateMealStore($name, $maxAge, $calorie, $minAge, $typeMenu)
    {
        $this->mealStore->name = $name;
        $this->mealStore->max_age = $maxAge;
        $this->mealStore->min_age = $minAge;
        $this->mealStore->type_menu = $typeMenu;
        if (!empty($calorie)) {
            $this->mealStore->calorie = $calorie;
        }
        $this->mealStore->save();
        return $this->mealStore;
    }

    /**
     * Method to delete storeMenu related to nutritionist
     *
     * @return bool|mixed|null
     *
     * @throws \Exception
     */
    public function deleteMealStore()
    {
        return $this->mealStore->delete();
    }

    /**
     * Add ingredient to a storeMenu related to nutritionist
     *
     * @param int $mealStoreId
     * @param int $ingredientId
     * @param int $amount
     * @return bool|mixed|null
     */
    public static function addIngredientToMealStore($mealStoreId, $ingredientId, $amount)
    {
        return DB::table('ingredient_meal_store')->insert(
            ['meal_store_id' => $mealStoreId, 'ingredient_id' => $ingredientId, 'amount' => $amount]
        );
    }

    /**
     * Method for nutritionist to delete ingredient to the storeMenu.
     *
     * @param int $idIngredient
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteIngredientToMealStore($idIngredient)
    {
        return $this->mealStore->ingredients()->detach($idIngredient);
    }



}
