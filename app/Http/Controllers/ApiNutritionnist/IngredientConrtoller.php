<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientPutRequest;
use App\Http\Requests\IngredientRequest;
use App\Repositories\IngredientRepository;
use JWTAuth;

class IngredientConrtoller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index()
    {
        $nutritionist = auth()->user();
        $ingredientRepository = new IngredientRepository($nutritionist);
        $ingredients = $ingredientRepository->getAllIngredients();
        return response()->json(
            [
                'success' => true,
                'ingredients' => $ingredients,
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IngredientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(IngredientRequest $request)
    {
        $nutritionist = auth()->user();
        $ingredientRepository = new IngredientRepository($nutritionist);
        $ingredient = $ingredientRepository->createIngredient($request);
        if ($ingredient) {
            return response()->json(
                [
                    'success' => true,
                    'ingredient' => $ingredient,
                ],
                200
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $nutritionist = auth()->user();
        $ingredientRepository = new IngredientRepository($nutritionist);
        $ingredient = $ingredientRepository->getIngredient($id);
        return response()->json(
            [
                'success' => true,
                'ingredient' => $ingredient,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IngredientPutRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(IngredientRequest $request, $id)
    {
        $nutritionist = auth()->user();
        $ingredientRepository = new IngredientRepository($nutritionist);
        $ingredient = $ingredientRepository->updateIngredient($request, $id);
        return response()->json(
            [
                'success' => $ingredient,
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $nutritionist = auth()->user();
        $ingredientRepository = new IngredientRepository($nutritionist);
        $ingredientRepository->deleteIngredient($id);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

}
