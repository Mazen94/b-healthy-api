<?php


namespace App\Repositories;


use App\Nutritionist;
use App\Storemenu;
use Illuminate\Http\JsonResponse;


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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStoreMenus()
    {
        $storemenus = $this->nutritionist->storemenus;

        return $storemenus;
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
        $menu->nom = $request->nom;
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
        $menu =  $this->nutritionist->storemenus()->findOrFail($id);
        $menu->nom = $request['nom'];
        $menu->max_age = $request['max_age'];
        $menu->min_age = $request['min_age'];
        $menu->calorie = $request['calorie'];
        $menu->type_menu = $request['type_menu'];
        $menu->save();
        return $menu;

    }
}
