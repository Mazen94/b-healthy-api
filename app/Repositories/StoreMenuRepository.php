<?php


namespace App\Repositories;


use App\Nutritionist;
use App\Storemenu;
use App\StoremenuIngredient;


class StoreMenuRepository
{
    protected $nutritionist;

    /**
     * PatientRepository constructor.
     * @param Nutritionist $nutritionist
     */
    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * Method to get all StoreMenu
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllStoreMenus()
    {
        return $this->nutritionist->storemenus()->paginate();;
    }

    /**
     * method to get only one StoreMenu with the ingredients
     * @param $id
     * @return array $data;
     */
    public function getStoreMenuWithIngredients($id)
    {
        $storemenu = $this->nutritionist->storemenus()->findOrFail($id);
        $storemenu['ingredients'] = $storemenu->ingredients;
        return $storemenu;
    }

    /**
     * Method to create a new store menu
     *
     * @param $request
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createStoreMenu($request)
    {
        $menu = new Storemenu();
        $menu->name = $request->name;
        $menu->max_age = $request->max_age;
        $menu->min_age = $request->min_age;
        $menu->type_menu = $request->type_menu;
        return $this->nutritionist->storemenus()->save($menu);
    }

    /**
     * Method to update storeMenu related to patient
     *
     * @param $request
     * @return bool|false|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasMany[]
     */
    public function updateStoreMenu($request, $id)
    {
        $menu = $this->nutritionist->storemenus()->findOrFail($id);
        $menu->name = $request['name'];
        $menu->max_age = $request['max_age'];
        $menu->min_age = $request['min_age'];
        $menu->calorie = $request['calorie'];
        $menu->type_menu = $request['type_menu'];
        $menu->save();
        return $menu;
    }

    /**
     * Method to delete storeMenu
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteStoreMenu($id)
    {
        $menu = $this->nutritionist->storemenus()->findOrFail($id);
        return $menu->delete();
    }

    /**
     * Add ingredient to a storeMenu
     *
     * @param $request
     * @param $id_storemenus
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function addIngredientToStoreMenu($request, $id_storemenus)
    {
        $storeMenu = new StoremenuIngredient();
        $storeMenu->storemenu_id = $id_storemenus;
        $storeMenu->ingredients_id = $request['id'];
        $storeMenu->amount = $request['amount'];
        $storeMenu->save();
        return $storeMenu;
    }

    /**
     * delete ingredient to a storeMenu
     *
     * @param $id_storemenus
     * @param $id_storemenus
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteIngredientToStoreMenu($id_storemenus, $id_ingredient)
    {
        $menu = $this->nutritionist->storemenus()->findOrFail($id_storemenus);
        if ($menu->ingredients()->findOrFail($id_ingredient)) {
            return $menu->ingredients()->detach($id_ingredient);
        }
    }

    /**
     * update amount ingredient to a storeMenu
     *
     * @param $id_storemenus
     * @param $id_storemenus
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function updateIngredientToStoreMenu($request, $id_storeMenu, $id_ingredient)
    {
        $menu = $this->nutritionist->storemenus()->findOrFail($id_storeMenu);
        $ingredient = $menu->ingredients()->findOrFail($id_ingredient);
        $ingredient->pivot->amount = $request['amount'];
        $ingredient->pivot->save();
        return $ingredient->pivot;
    }

}
