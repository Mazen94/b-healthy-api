<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealStoreRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\MealStoreRepository;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealStoreController extends Controller
{
    /**
     * Display a listing of the storeMenus related to nutritionist.
     *
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function index(PaginationRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', 'created_at');
        $orderDirection = $request->input('orderDirection', 'desc');
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $mealStores = $nutritionistRepository->paginateMealStore($page, $perPage, $orderBy, $orderDirection);
        return response()->json(['data' => $mealStores,], 200);
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
        $calorie = $request->input('calorie', 0);
        $minAge = $request->input('min_age');
        $typeMenu = $request->input('type_menu');
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $mealStore = $nutritionistRepository->createMealStore($name, $maxAge, $calorie, $minAge, $typeMenu);
        return response()->json(['data' => $mealStore,], 200);
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
        return response()->json(['data' => $mealStore,], 200);
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
        return response()->json(['data' => $mealStoreWithIngredients,], 200);
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
        return response()->json(['data' => $menuUpdated,], 200);
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
        return response()->json(['data' => true,], 200);
    }


}
