<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
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

    /**
     * Method to get follow-up rate for last recommendation
     * @param $patientId
     * @return mixed
     * @throws \Exception
     */
    public function followUpRate($patientId)
    {
        $numbOfBadMenus = 0;
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $patientRepository = new PatientRepository($patient);
        $recommendation = $patientRepository->getLastRecommendation();
        if ($recommendation) {
            $menusCreatedByPatient = MenuRepository::menusCreatedPatient($recommendation->id);
            $currentDate = new \DateTime(date('Y-m-d '));
            $dataOfRecommendation = new \DateTime(date('Y-m-d', strtotime($recommendation->updated_at)));
            $difference = $currentDate->diff($dataOfRecommendation);
            $numberOfMenus = $difference->days * 5;
            if ($numberOfMenus == 0) {
                return response()->json(['data' => 100], 200);
            } else {
                foreach ($menusCreatedByPatient as $menuCreatedByPatient) {
                    $nutritionistTypeMenu = MenuRepository::valueOfTypeMenu($menuCreatedByPatient->type_menu);
                    foreach ($recommendation->menus as $menu) {
                        if ($menu->type_menu == $nutritionistTypeMenu) {
                            if ($menu->calorie != $menuCreatedByPatient->calorie) {
                                $numbOfBadMenus++;
                            }
                        }
                    }
                }
                $followUp = (($numberOfMenus - $numbOfBadMenus) / $numberOfMenus) * 100;
                $data = round($followUp, 2);
                return response()->json(['data' => $data], 200);
            }
        } else {
            return response()->json(['data' => null], 200);
        }
    }
}
