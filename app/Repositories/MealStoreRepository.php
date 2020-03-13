<?php


namespace App\Repositories;

use App\MealStore;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;


class MealStoreRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * method to get only one StoreMenu with the ingredients related to nutritionist
     * @param int $age
     * @return Collection
     */
    public function getMealStoreWithIngredientsByAge($age)
    {
        return $this->model->mealStore()
            ->where('min_age', '<=', $age)
            ->where('max_age', '>=', $age)
            ->get();
    }

    /**
     * Method to create a new store menu related to nutritionist
     *
     * @param string $name
     * @param int $maxAge
     * @param int $minAge
     * @param int $calorie
     * @param string $typeMenu
     *
     * @return false|Model
     */
    public function createMealStore($name, $maxAge, $calorie, $minAge, $typeMenu)
    {
        $menu = new MealStore();
        $menu->name = $name;
        $menu->max_age = $maxAge;
        $menu->min_age = $minAge;
        $menu->type_menu = $typeMenu;
        if (!empty($calorie)) {
            $menu->calorie = $calorie;
        }
        return $this->model->mealStore()->save($menu);
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
        $this->model->name = $name;
        $this->model->max_age = $maxAge;
        $this->model->min_age = $minAge;
        $this->model->type_menu = $typeMenu;
        if (!empty($calorie)) {
            $this->model->calorie = $calorie;
        }
        $this->model->save();
        return $this->model;
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
        return $this->model->delete();
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
        return $this->model->ingredients()->detach($idIngredient);
    }

    /**
     * update amount ingredient to a storeMenu
     *
     * @param string $amount
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function updateAmountIngredientInMealStore($amount)
    {
        $this->model->pivot->amount = $amount;
        $this->model->pivot->save();
        return $this->model->pivot;
    }

}
