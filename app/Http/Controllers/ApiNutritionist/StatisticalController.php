<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Repositories\NutritionistRepository;
use App\Repositories\PatientRepository;
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
    /**
     * get the weight , legs , belly and chest progression per month
     * @param int $patientId
     * @return mixed
     */
    public function getStatisticalOfPatient($patientId)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $patientRepository = new PatientRepository($patient);
        $data['weights'] = $patientRepository->weightAndMonth();
        $data['legs'] = $patientRepository->legsAndMonth();
        $data['belly'] = $patientRepository->bellyAndMonth();
        $data['chest'] = $patientRepository->chestAndMonth();
        return response()->json(['data' => $data], 200);
    }
}
