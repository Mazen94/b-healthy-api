<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use App\Repositories\PatientRepository;
use App\Visit;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    /**
     * get the weight and month in this year
     * @return mixed
     */
    public function getWeightMonth()
    {
        $patient = auth()->user();
        $patientRepository = new PatientRepository($patient);
        $weights = $patientRepository->weightAndMonth();
        return response()->json(['data' => $weights], 200);
    }

    /**
     * Method to get follow-up rate for last recommendation
     * @return mixed
     * @throws \Exception
     */
    public function followUpRate()
    {
        $numbOfBadMenus = 0;
        $patient = auth()->user();
        $patientRepository = new PatientRepository($patient);
        $recommendation = $patientRepository->getRecommendationByPatient();
        $menusCreated = MenuRepository::menusCreatedPatient($recommendation->id);
        $currentDate = new \DateTime(date('Y-m-d '));
        $dataOfRecommendation = new \DateTime(date('Y-m-d', strtotime($recommendation->updated_at)));
        $difference = $currentDate->diff($dataOfRecommendation);
        $numberOfMenus = $difference->days * 5;
        foreach ($menusCreated as $menuCreated) {
            $nutritionistTypeMenu = MenuRepository::valueOfTypeMenu($menuCreated->type_menu);
            foreach ($recommendation->menus as $menu) {
                if ($menu->type_menu == $nutritionistTypeMenu) {
                    if ($menu->calorie != $menuCreated->calorie) {
                        $numbOfBadMenus++;
                    }
                }
            }
        }
        $followUp = (($numberOfMenus - $numbOfBadMenus) / $numberOfMenus) * 100;
        return response()->json(['data' => round($followUp, 2)], 200);
    }
}

