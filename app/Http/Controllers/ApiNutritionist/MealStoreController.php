<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealStoreIngredientRequest;
use App\Http\Requests\MealStoreRequest;
use App\Repositories\MealStoreRepository;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealStoreController extends Controller
{
    /**
     * Display a listing of the storeMenus related to nutritionist.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $nutritionist = auth()->user();
        $mealStores = $nutritionist->mealStore()->paginate();
        return response()->json(['MealStore' => $mealStores,], 200);
    }

    /**
     * Store a newly created storeMenus related to nutritionist in storage.
     *
     * @param MealStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(MealStoreRequest $request)
    {
        $nutritionist = auth()->user();
        $name = $request->input('name');
        $maxAge = $request->input('max_age');
        $calorie = $request->input('calorie');
        $minAge = $request->input('min_age');
        $typeMenu = $request->input('type_menu');
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $mealStore = $nutritionistRepository->createMealStore($name, $maxAge, $calorie, $minAge, $typeMenu);
        return response()->json(['MealStore' => $mealStore,], 200);
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
        $mealStore = $nutritionist->mealStore()->findOrFail($id);
        $mealStore['ingredients'] = $mealStore->ingredients;
        return response()->json(['StoreMenu' => $mealStore,], 200);
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
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $mealStoreWithIngredients = $nutritionistRepository->getMealStoreWithIngredientsByAge($age);
        return response()->json(['MealStore' => $mealStoreWithIngredients,], 200);
    }

    /**
     * Method to update storeMenu related to nutritionist
     *
     * @param MealStoreRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(MealStoreRequest $request, $id)
    {
        $nutritionist = auth()->user();
        $mealStore = $nutritionist->mealStore()->findOrFail($id);
        $name = $request->input('name');
        $maxAge = $request->input('max_age');
        $calorie = $request->input('calorie');
        $minAge = $request->input('min_age');
        $typeMenu = $request->input('type_menu');
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $menuUpdated = $mealStoreRepository->updateMealStore($name, $maxAge, $calorie, $minAge, $typeMenu);
        return response()->json(['MealStore' => $menuUpdated,], 200);
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
        $mealStore = $nutritionist->mealStore()->findOrFail($id);
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $mealStoreRepository->deleteMealStore();
        return response()->json(['success' => true,], 200);
    }

    /**
     * Method for nutritionist add ingredient to the storeMenu.
     *
     * @param MealStoreIngredientRequest $request
     * @param int $idStoreMenu
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function addIngredient(MealStoreIngredientRequest $request, $idStoreMenu)
    {
        $idIngredient = $request->input('id');
        $amount = $request->input('amount');
        $mealStore = MealStoreRepository::addIngredientToMealStore($idStoreMenu, $idIngredient, $amount);
        return response()->json(['storeMenu' => $mealStore,], 200);
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
        $mealStore = $nutritionist->mealStore()->findOrFail($idStoreMenu);
        $mealStore->ingredients()->findOrFail($idIngredient);
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $mealStoreRepository->deleteIngredientToMealStore($idIngredient);
        return response()->json(['success' => true,], 200);
    }

    /**
     * update amount ingredient to the storeMenu.
     *
     * @param MealStoreIngredientRequest $request
     * @param int $idStoreMenu
     * @param int $idIngredient
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public static function updateAmountPivotIngredient(MealStoreIngredientRequest $request, $idStoreMenu, $idIngredient)
    {
        $nutritionist = auth()->user();
        $menu = $nutritionist->mealStore()->findOrFail($idStoreMenu);
        $ingredient = $menu->ingredients()->findOrFail($idIngredient);
        $amount = $request->input('amount');
        $mealStoreRepository = new MealStoreRepository($ingredient);
        $amountUpdated = $mealStoreRepository->updateAmountIngredientInMealStore($amount);
        return response()->json(['amount' => $amountUpdated,], 200);
    }

}
