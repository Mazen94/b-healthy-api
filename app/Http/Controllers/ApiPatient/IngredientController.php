<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Ingredient;
use App\Menu;
use App\Repositories\MenuRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Method to get all patients related to nutritionist
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
        $search = $request->input('search', '');
        $patient = auth()->user();

        $patientRepository = new PatientRepository($patient);
        $patients = $patientRepository->paginateIngredient($page, $perPage, $orderBy, $orderDirection, $search);
        return response()->json(['data' => $patients], 200);
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
    public function addIngredientToMenu(Request $request)
    {
        $idIngredient = $request->input('idIngredient');
        $idMenu = $request->input('idMenu');
        $amount = $request->input('amount');
        $menu = Menu::findOrFail($idMenu);
        $ingredient = Ingredient::findOrFail($idIngredient);
        $caloriesOfIngredient = $ingredient->calorie;
        $caloriesOfMenu = $menu->calorie;
        $defaultAmount = $ingredient->amount;
        $caloriesOfMenu = $caloriesOfMenu + (($amount / $defaultAmount) * $caloriesOfIngredient);
        $menuRepository = new MenuRepository($menu);
        $menu = $menuRepository->addIngredientToMenu($idMenu, $caloriesOfMenu, $idIngredient, $amount);
        return response()->json(['data' => $menu,], 200);
    }

}
