<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Http\Requests\MealStoreIngredientRequest;
use App\Http\Requests\PaginationRequest;
use App\Ingredient;
use App\Repositories\IngredientRepository;
use App\Repositories\MealStoreRepository;
use App\Repositories\NutritionistRepository;
use Illuminate\Auth\Access\AuthorizationException;
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
        $perPage = $request->input('perPage', 20);
        $orderBy = $request->input('orderBy', 'created_at');
        $orderDirection = $request->input('orderDirection', 'desc');
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $ingredients = $nutritionistRepository->paginateIngredients($page, $perPage, $orderBy, $orderDirection);
        return response()->json(['data' => $ingredients], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param IngredientRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(IngredientRequest $request)
    {
        $name = $request->input('name');
        $amount = $request->input('amount');
        $calorie = $request->input('calorie');
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $ingredient = $nutritionistRepository->createIngredient($name, $amount, $calorie);
        return response()->json(['data' => $ingredient], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $this->authorize('view', $ingredient);
        return response()->json(['data' => $ingredient], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IngredientRequest $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(IngredientRequest $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $this->authorize('update', $ingredient);
        $name = $request->input('name');
        $amount = $request->input('amount');
        $calorie = $request->input('calorie');
        $ingredientRepository = new IngredientRepository($ingredient);
        $ingredient = $ingredientRepository->updateIngredient($name, $amount, $calorie);
        return response()->json(['data' => $ingredient], 200);
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
        $ingredient = Ingredient::findOrFail($id);
        $this->authorize('delete', $ingredient);
        $ingredientRepository = new IngredientRepository($ingredient);
        $ingredientRepository->deleteIngredient();
        return response()->json(['data' => true,], 200);
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
        $amount = $request->input('amount'); //the new amount of ingredient
        $nutritionist = auth()->user();
        $check = MealStoreRepository::checkRecordExists($idIngredient, $idStoreMenu);
        //check if the record exists in the table or not
        if (isset($check)) {
            return response()->json(['data' => __('messages.IngredientExists'),], 200);
        }
        $mealStore = $nutritionist->mealStore()->findOrFail($idStoreMenu);
        $ingredient = $nutritionist->ingredients()->findOrFail($idIngredient);
        $caloriesOfIngredient = $ingredient->calorie; //Default number of calories of ingredient
        $caloriesOfMealStore = $mealStore->calorie; //Number calories of menu
        $defaultAmount = $ingredient->amount; //Default number of amount of ingredient
        //new value of calorie of menu
        $caloriesOfMealStore = $caloriesOfMealStore + round((($amount / $defaultAmount) * $caloriesOfIngredient), 1);
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $mealStore = $mealStoreRepository->addIngredientToMealStore(
            $idStoreMenu,
            $caloriesOfMealStore,
            $idIngredient,
            $amount
        );
        return response()->json(['data' => $mealStore,], 201);
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
        $mealStoreCalorie = $mealStore->calorie;//Number calories of menu
        $defaultAmount = $ingredient->amount;//Default number of amount of ingredient
        $ingredientCalorie = $ingredient->calorie;//Default number of calories of ingredient
        $amount = $ingredient->pivot->amount; //number of amount of ingredient
        //new value of calorie of menu
        $mealStoreCalorie = $mealStoreCalorie - round((($amount / $defaultAmount) * $ingredientCalorie), 1);
        $mealStoreRepository = new MealStoreRepository($mealStore);
        $menu = $mealStoreRepository->deleteIngredientToMealStore($idIngredient, $mealStoreCalorie);
        return response()->json(['data' => $menu,], 200);
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
        $mealStore = $nutritionist->mealStore()->findOrFail($idStoreMenu);
        $ingredient = $mealStore->ingredients()->findOrFail($idIngredient);
        $mealStoreCalorie = $mealStore->calorie; //Number calories of menu
        $defaultAmount = $ingredient->amount; //Default number of amount of ingredient
        $ingredientCalorie = $ingredient->calorie; //Default number of calories of ingredient
        $oldAmount = $ingredient->pivot->amount; //number of amount of ingredient
        $newAmount = $request->input('amount'); //the new amount of ingredient
        $amount = $newAmount - $oldAmount;
        //new value of calorie of menu
        $mealStoreCalorie = $mealStoreCalorie + round((($amount / $defaultAmount) * $ingredientCalorie), 1);
        $ingredientRepository = new IngredientRepository($ingredient);
        $amountUpdated = $ingredientRepository->updateAmountIngredientInMealStore(
            $newAmount,
            $mealStore,
            $mealStoreCalorie
        );
        return response()->json(['data' => $amountUpdated,], 200);
    }
}
