<?php


namespace App\Repositories;

use App\IngredientMealStore;
use App\MealStore;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
     * @param int $caloriesOfMealStore
     * @param int $ingredientId
     * @param int $amount
     * @return bool|mixed|null
     */
    public function addIngredientToMealStore($mealStoreId, $caloriesOfMealStore, $ingredientId, $amount)
    {
        $this->mealStore->calorie = $caloriesOfMealStore;
        $this->mealStore->save();
        $ingredientMealStore = new IngredientMealStore();
        $ingredientMealStore->ingredient_id = $ingredientId;
        $ingredientMealStore->meal_store_id = $mealStoreId;
        $ingredientMealStore->amount = $amount;
        $ingredientMealStore->save();
        return $this->mealStore;
    }

    /**
     * Method for nutritionist to delete ingredient to the storeMenu.
     *
     * @param int $idIngredient
     * @param int $mealStoreCalorie
     * @return bool|mixed|null
     */
    public function deleteIngredientToMealStore($idIngredient, $mealStoreCalorie)
    {
        $this->mealStore->calorie = $mealStoreCalorie;
        $this->mealStore->save();
        $this->mealStore->ingredients()->detach($idIngredient);
        return $this->mealStore;
    }

    /**
     * Method Checking If a Record Exists
     *
     * @param int $idIngredient
     * @param int $idMealStore
     * @return bool|mixed|null
     */
    public static function checkRecordExists($idIngredient, $idMealStore)
    {
        return IngredientMealStore::where('meal_store_id', $idMealStore)->where(
            'ingredient_id',
            $idIngredient
        )->first();
    }

}
