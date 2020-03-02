<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientPutRequest;
use App\Http\Requests\IngredientRequest;
use App\Repositories\IngredientRepository;
use JWTAuth;

class IngredientConrtoller extends Controller
{
    protected $ingredientRepository;
    protected $nutritionist;

    /**
     * PatientController constructor.
     * @param IngredientRepository $patientRepository
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->ingredientRepository = new IngredientRepository($this->nutritionist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index()
    {
        $ingredients = $this->ingredientRepository->getAllIngredients();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(IngredientRequest $request)
    {
        $ingredient = $this->ingredientRepository->createIngredient($request);
        if (empty($ingredient)) {
            return response()->json(
                [
                    'success' => false,
                    'ingredient' => 'Error to create ingredient',
                ],
                400
            );
        }
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
        $ingredient = $this->ingredientRepository->getIngredient($id);
        if (empty($ingredient)) {
            return response()->json(
                [
                    'success' => false,
                    'ingredient' => 'Not Found',
                ],
                400
            );
        }
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
    public function update(IngredientPutRequest $request, $id)
    {
        $ingredient = $this->ingredientRepository->updateIngredient($request, $id);
        return response()->json(
            [
                'success' => true,
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
        if ($this->ingredientRepository->deleteIngredient($id)) {
            return response()->json(
                [
                    'success' => true,
                    'ingredient' => 'deleted',
                ],
                200
            );
        }
        return response()->json(
            [
                'success' => false,
                'ingredient' => 'Cannot delete this ingredient',
            ],
            400
        );
    }

}
