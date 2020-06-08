<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Ingredient;
use App\Menu;
use App\Repositories\IngredientRepository;
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
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function addIngredientToMenu(Request $request)
    {
        $idIngredient = $request->input('idIngredient');
        $idMenu = $request->input('idMenu');
        $amount = $request->input('amount');
        $check = MenuRepository::checkRecordExists($idIngredient, $idMenu);
        //check if the record exists in the table or not
        if (isset($check)) {
            return response()->json(['data' => __('messages.IngredientExists'),], 400);
        }
        $menu = Menu::findOrFail($idMenu);
        $ingredient = Ingredient::findOrFail($idIngredient);
        $caloriesOfIngredient = $ingredient->calorie;
        $caloriesOfMenu = $menu->calorie;
        $defaultAmount = $ingredient->amount;
        $caloriesOfMenu = $caloriesOfMenu + (($amount / $defaultAmount) * $caloriesOfIngredient);
        $menuRepository = new MenuRepository($menu);
        $menu = $menuRepository->addIngredientToMenu($idMenu, $caloriesOfMenu, $idIngredient, $amount);
        return response()->json(['data' => $menu,], 201);
    }

    /**
     * Delete Ingredient from menu
     * @param $idMenu
     * @param $idIngredient
     * @return mixed
     */
    public function detachIngredientToMenu($idMenu, $idIngredient)
    {
        $menu = Menu::findOrFail($idMenu);
        $ingredients = $menu->ingredients();
        $ingredient = $ingredients->findOrFail($idIngredient);
        $caloriesOfIngredient = $ingredient->calorie;
        $defaultAmount = $ingredient->amount;
        $caloriesOfMenu = $menu->calorie;
        $amount = $ingredient->pivot->amount;
        $caloriesOfMenu = $caloriesOfMenu - (($amount / $defaultAmount) * $caloriesOfIngredient);
        $menuRepository = new MenuRepository($menu);
        $menu = $menuRepository->deleteIngredientFromMenu($caloriesOfMenu, $idIngredient);
        return response()->json(['data' => $menu,], 200);
    }

    public function updateAmountOfIngredient(Request $request, $idMenu, $idIngredient)
    {
        $menu = Menu::findOrFail($idMenu);
        $ingredients = $menu->ingredients();
        $ingredient = $ingredients->findOrFail($idIngredient);
        $menuCalorie = $menu->calorie;
        $defaultAmount = $ingredient->amount;
        $ingredientCalorie = $ingredient->calorie;
        $oldAmount = $ingredient->pivot->amount;
        $newAmount = $request->input('amount');
        $amount = $newAmount - $oldAmount;
        $mealStoreCalorie = $menuCalorie + (($amount / $defaultAmount) * $ingredientCalorie);
        $ingredientRepository = new IngredientRepository($ingredient);
        $amountUpdated = $ingredientRepository->updateAmountIngredientInMealStore($newAmount, $menu, $mealStoreCalorie);
        return response()->json(['data' => $amountUpdated,], 200);
    }
}
