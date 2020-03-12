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
        return response()->json(['StoreMenus' => $storeMenus,], 200);
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
        $name = $request->input('name');
        $maxAge = $request->input('max_age');
        $calorie = $request->input('calorie');
        $minAge = $request->input('min_age');
        $typeMenu = $request->input('type_menu');
        $storeMenuRepository = new StoreMenuRepository($nutritionist);
        $storeMenu = $storeMenuRepository->createStoreMenu($name, $maxAge, $calorie, $minAge, $typeMenu);
        return response()->json(['StoreMenu' => $storeMenu,], 200);
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
        return response()->json(['StoreMenu' => $storeMenu,], 200);
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
        $age = $request->input('age');
        $storeMenuRepository = new StoreMenuRepository($nutritionist);
        $storeMenuWithIngredients = $storeMenuRepository->getStoreMenuWithIngredientsByAge($age);
        return response()->json(['StoreMenu' => $storeMenuWithIngredients,], 200);
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
        $name = $request->input('name');
        $maxAge = $request->input('max_age');
        $calorie = $request->input('calorie');
        $minAge = $request->input('min_age');
        $typeMenu = $request->input('type_menu');
        $storeMenuRepository = new StoreMenuRepository($storeMenu);
        $menuUpdated = $storeMenuRepository->updateStoreMenu($name, $maxAge, $calorie, $minAge, $typeMenu);
        return response()->json(['StoreMenu' => $menuUpdated,], 200);
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
        $storeMenuRepository = new StoreMenuRepository($storeMenu);
        $storeMenuRepository->deleteStoreMenu();
        return response()->json(['success' => true,], 200);
    }

    /**
     * Method for nutritionist add ingredient to the storeMenu.
     *
     * @param StoreMenuIngredientRequest $request
     * @param int $idStoreMenu
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function addIngredient(StoreMenuIngredientRequest $request, $idStoreMenu)
    {
        $idIngredient = $request->input('id');
        $amount = $request->input('amount');
        $storeMenu = StoreMenuRepository::addIngredientToStoreMenu($idStoreMenu, $idIngredient, $amount);
        return response()->json(['storeMenu' => $storeMenu,], 200);
    }

    /**
     * Method for nutritionist to delete ingredient to the storeMenu.
     *
     * @param int $idStoreMenu
     * @param int $idIngredient
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function deleteIngredient($idStoreMenu, $idIngredient)
    {
        $nutritionist = auth()->user();
        $storeMenu = $nutritionist->storemenus()->findOrFail($idStoreMenu);
        $storeMenu->ingredients()->findOrFail($idIngredient);
        $storeMenuRepository = new StoreMenuRepository($storeMenu);
        $storeMenuRepository->deleteIngredientToStoreMenu($idIngredient);
        return response()->json(['success' => true,], 200);
    }

    /**
     * update amount ingredient to the storeMenu.
     *
     * @param StoreMenuIngredientRequest $request
     * @param int $idStoreMenu
     * @param int $idIngredient
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public static function updateAmountPivotIngredient(StoreMenuIngredientRequest $request, $idStoreMenu, $idIngredient)
    {
        $nutritionist = auth()->user();
        $menu = $nutritionist->storemenus()->findOrFail($idStoreMenu);
        $ingredient = $menu->ingredients()->findOrFail($idIngredient);
        $amount = $request->input('amount');
        $storeMenuRepository = new StoreMenuRepository($ingredient);
        $amountUpdated = $storeMenuRepository->updateAmountIngredientInStoreMenu($amount);
        return response()->json(['amount' => $amountUpdated,], 200);
    }

}
