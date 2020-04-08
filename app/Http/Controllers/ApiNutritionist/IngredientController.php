<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\IngredientRepository;
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
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        $nutritionist = auth()->user();
        $ingredients = $nutritionist->ingredients;
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

}
