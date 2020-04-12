<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Http\Requests\MealStoreIngredientRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\IngredientRepository;
use App\Repositories\MealStoreRepository;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\JsonResponse;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function index(PaginationRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', null);
        $orderDirection = $request->input('orderDirection', 'asc');
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $ingredients = $nutritionistRepository->paginateIngredients($page, $perPage, $orderBy, $orderDirection);
        return response()->json(['ingredients' => $ingredients], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param IngredientRequest $request
     * @return JsonResponse
     */
    public function store(IngredientRequest $request)
    {
        $nutritionist = auth()->user();
        $name = $request->input('name');
        $amount = $request->input('amount');
        $calorie = $request->input('calorie');
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $ingredient = $nutritionistRepository->createIngredient($name, $amount, $calorie);
        return response()->json(['ingredient' => $ingredient], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $ingredient = auth()->user()->ingredients()->findOrFail($id);
        return response()->json(['ingredient' => $ingredient], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IngredientRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(IngredientRequest $request, $id)
    {
        $nutritionist = auth()->user();
        $ingredient = $nutritionist->ingredients()->findOrFail($id);
        $name = $request->input('name');
        $amount = $request->input('amount');
        $calorie = $request->input('calorie');
        $ingredientRepository = new IngredientRepository($ingredient);
        $ingredient = $ingredientRepository->updateIngredient($name, $amount, $calorie);
        return response()->json(['ingredient' => $ingredient], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $nutritionist = auth()->user();
        $ingredient = $nutritionist->ingredients()->findOrFail($id);
        $ingredientRepository = new IngredientRepository($ingredient);
        $ingredientRepository->deleteIngredient();
        return response()->json(['success' => true,], 200);
    }
    /**
     * Method for nutritionist add ingredient to the storeMenu and update the calories of mealStore .
     *
     * @param MealStoreIngredientRequest $request
     * @param int $idStoreMenu
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function addIngredientToMealStore(MealStoreIngredientRequest $request, $idStoreMenu)
    {
        $idIngredient = $request->input('id');
        $amount = $request->input('amount');
        $nutritionist = auth()->user();
        $mealStore = $nutritionist->mealStore()->findOrFail($idStoreMenu);
        $ingredient = $nutritionist->ingredients()->findOrFail($idIngredient);
        $caloriesOfIngredient = $ingredient->calorie;
        $caloriesOfMealStore = $mealStore->calorie;
        $defaultAmount = $ingredient->amount;
        $caloriesOfMealStore = $caloriesOfMealStore + (($amount / $defaultAmount) * $caloriesOfIngredient);
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $mealStore = $mealStoreRepository->addIngredientToMealStore(
            $idStoreMenu,
            $caloriesOfMealStore,
            $idIngredient,
            $amount
        );
        return response()->json(['storeMenu' => $mealStore,], 200);
    }
    /**
     * Method for nutritionist to delete ingredient to the storeMenu and update the calories of mealStore .
     *
     * @param int $idStoreMenu
     * @param int $idIngredient
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function deleteIngredientMealStore($idStoreMenu, $idIngredient)
    {
        $nutritionist = auth()->user();
        $mealStore = $nutritionist->mealStore()->findOrFail($idStoreMenu);
        $ingredient = $mealStore->ingredients()->findOrFail($idIngredient);
        $mealStoreCalorie = $mealStore->calorie;
        $defaultAmount = $ingredient->amount;
        $ingredientCalorie = $ingredient->calorie;
        $amount = $ingredient->pivot->amount;
        $mealStoreCalorie = $mealStoreCalorie - (($amount / $defaultAmount) * $ingredientCalorie);
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $menu = $mealStoreRepository->deleteIngredientToMealStore($idIngredient, $mealStoreCalorie);
        return response()->json(['mealStore' => $menu,], 200);
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
        $ingredientRepository = new IngredientRepository($ingredient);
        $amountUpdated = $ingredientRepository->updateAmountIngredientInMealStore($amount);
        return response()->json(['amount' => $amountUpdated,], 200);
    }
}
