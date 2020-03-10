<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Repositories\IngredientRepository;


class IngredientConrtoller extends Controller
{
    //TODO test this controller
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index()
    {
        $nutritionist = auth()->user();
        $ingredients = $nutritionist->ingredients()->paginate();
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

        $ingredient = IngredientRepository::createIngredient(
            $nutritionist,
            $request->input('name'),
            $request->input('quantite'),
            $request->input('calorie')
        );

        return response()->json(
            [
                'success' => true,
                'ingredient' => $ingredient,
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ingredient = auth()->user()->ingredients()->findOrFail($id);
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
     * @param IngredientRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(IngredientRequest $request, $id)
    {
        $nutritionist = auth()->user();
        $ingredient = $nutritionist->ingredients()->findOrFail($id);
        $ingredient = IngredientRepository::updateIngredient(
            $request->input('name'),
            $request->input('quantite'),
            $request->input('calorie'),
            $ingredient
        );
        return response()->json(
            [
                'success' => true,
                'ingredient' => $ingredient
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
        $ingredient = $nutritionist->ingredients()->findOrFail($id);
        IngredientRepository::deleteIngredient($ingredient);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

}
