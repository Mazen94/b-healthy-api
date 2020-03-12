<?php


namespace App\Repositories;

use App\Storemenu;
use App\StoremenuIngredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class StoreMenuRepository
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
    public function getStoreMenuWithIngredientsByAge($age)
    {
        return $this->model->storemenus()
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
    public function createStoreMenu($name, $maxAge, $calorie, $minAge, $typeMenu)
    {
        $menu = new Storemenu();
        $menu->name = $name;
        $menu->max_age = $maxAge;
        $menu->min_age = $minAge;
        $menu->type_menu = $typeMenu;
        if (!empty($calorie)) {
            $menu->calorie = $calorie;
        }
        return $this->model->storemenus()->save($menu);
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
    public function updateStoreMenu($name, $maxAge, $calorie, $minAge, $typeMenu)
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
    public function deleteStoreMenu()
    {
        return $this->model->delete();
    }

    /**
     * Add ingredient to a storeMenu related to nutritionist
     *
     * @param int $storeMenuId
     * @param int $ingredientsId
     * @param int $amount
     * @return bool|mixed|null
     */
    public static function addIngredientToStoreMenu($storeMenuId, $ingredientsId, $amount)
    {
        $storeMenu = new StoremenuIngredient();
        $storeMenu->storemenu_id = $storeMenuId;
        $storeMenu->ingredients_id = $ingredientsId;
        $storeMenu->amount = $amount;
        $storeMenu->save();
        return $storeMenu;
    }

    /**
     * Method for nutritionist to delete ingredient to the storeMenu.
     *
     * @param int $idIngredient
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteIngredientToStoreMenu($idIngredient)
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
    public function updateAmountIngredientInStoreMenu($amount)
    {
        $this->model->pivot->amount = $amount;
        $this->model->pivot->save();
        return $this->model->pivot;
    }

}
