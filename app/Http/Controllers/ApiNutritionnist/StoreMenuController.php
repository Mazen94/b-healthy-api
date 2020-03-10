<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuIngredientRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Repositories\StoreMenuRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreMenuController extends Controller
{
    /**
     * Display a listing of the storeMenus related to nutritionist.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $nutritionist = auth()->user();
        $storeMenus = $nutritionist->storemenus()->paginate();
        return response()->json(
            [
                'success' => true,
                'StoreMenus' => $storeMenus,
            ],
            200
        );
    }

    /**
     * Store a newly created storeMenus related to nutritionist in storage.
     *
     * @param StoreMenuRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreMenuRequest $request)
    {
        $nutritionist = auth()->user();
        $storeMenu = StoreMenuRepository::createStoreMenu(
            $nutritionist,
            $request->input('name'),
            $request->input('max_age'),
            $request->input('calorie'),
            $request->input('min_age'),
            $request->input('type_menu')
        );

        return response()->json(
            [
                'success' => true,
                'StoreMenu' => $storeMenu,
            ],
            200
        );
    }

    /**
     * Display the specified StoreMenu with these ingredients related to nutritionist.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $nutritionist = auth()->user();
        $storeMenu = $nutritionist->storemenus()->findOrFail($id);
        $storeMenu['ingredients'] = $storeMenu->ingredients;
        return response()->json(
            [
                'success' => true,
                'StoreMenu' => $storeMenu,
            ],
            200
        );
    }

    /**
     * Display the specified StoreMenu with these ingredients by age related to nutritionist.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function showByAge(Request $request)
    {
        $nutritionist = auth()->user();
        $storeMenuWithIngredients = StoreMenuRepository::getStoreMenuWithIngredientsByAge(
            $nutritionist,
            $request->input('age')
        );
        return response()->json(
            [
                'success' => true,
                'StoreMenu' => $storeMenuWithIngredients,
            ],
            200
        );
    }

    /**
     * Method to update storeMenu related to nutritionist
     *
     * @param StoreMenuRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(StoreMenuRequest $request, $id)
    {
        $nutritionist = auth()->user();
        $storeMenu = $nutritionist->storemenus()->findOrFail($id);
        $menuUpdated = StoreMenuRepository::updateStoreMenu(
            $storeMenu,
            $request->input('name'),
            $request->input('max_age'),
            $request->input('calorie'),
            $request->input('min_age'),
            $request->input('type_menu')
        );
        return response()->json(
            [
                'success' => $menuUpdated,
            ],
            200
        );
    }

    /**
     * Remove the specified storeMenu from storage related to nutritionist.
     *
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $nutritionist = auth()->user();
        $storeMenu = $nutritionist->storemenus()->findOrFail($id);
        StoreMenuRepository::deleteStoreMenu($storeMenu);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

    /**
     * Method for nutritionist add ingredient to the storeMenu.
     *
     * @param StoreMenuIngredientRequest $request
     * @param int $id_storeMenu
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function addIngredient(StoreMenuIngredientRequest $request, $id_storeMenu)
    {
        $storeMenu = StoreMenuRepository::addIngredientToStoreMenu(
            $id_storeMenu,
            $request->input('id'),
            $request->input('amount')
        );
        return response()->json(
            [
                'success' => true,
                'storeMenu' => $storeMenu,
            ],
            200
        );
    }

    /**
     * Method for nutritionist to delete ingredient to the storeMenu.
     *
     * @param int $id_storeMenu
     * @param int $id_ingredient
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function deleteIngredient($id_storeMenu, $id_ingredient)
    {
        $nutritionist = auth()->user();
        $menu = $nutritionist->storemenus()->findOrFail($id_storeMenu);
        $menu->ingredients()->findOrFail($id_ingredient);
        StoreMenuRepository::deleteIngredientToStoreMenu($menu, $id_ingredient);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

    /**
     * update amount ingredient to the storeMenu.
     *
     * @param StoreMenuIngredientRequest $request
     * @param int $id_storeMenu
     * @param int $id_ingredient
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public static function updateAmountPivotIngredient(
        StoreMenuIngredientRequest $request,
        $id_storeMenu,
        $id_ingredient
    ) {
        $nutritionist = auth()->user();
        $menu = $nutritionist->storemenus()->findOrFail($id_storeMenu);
        $ingredient = $menu->ingredients()->findOrFail($id_ingredient);
        $amountUpdated = StoreMenuRepository::updateAmountIngredientInStoreMenu(
            $ingredient,
            $request->input('amount')
        );
        return response()->json(
            [
                'success' => $amountUpdated,
            ],
            200
        );
    }

}
