<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    /**
     * Display the number of ingredients
     *
     */
    public function countIngredients()
    {
        $nutritionist = auth()->user();
        $countOfIngredient = $nutritionist->ingredients()->count();
        return response()->json(['data' => $countOfIngredient], 200);
    }
    /**
     * Display the number of menus
     *
     */
    public function countMenus()
    {
        $nutritionist = auth()->user();
        $countOfMenus = $nutritionist->mealStore()->count();
        return response()->json(['data' => $countOfMenus], 200);
    }
    /**
     * Display the number of menus
     *
     */
    public function genderPatient()
    {
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $patient = $nutritionistRepository->countGenderPatient();
        return response()->json(['data' => $patient], 200);
    }
    /**
     * get the number of patients by age group
     *
     */

    public function rangeAgePatient()
    {
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $patient = $nutritionistRepository->rangeAgePatient();
        return response()->json(['data' => $patient], 200);
    }

}
