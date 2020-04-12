<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * add a menu to a recommendation
     * this recommendation related to patient
     *
     * @param Request $request
     * @param int $patientId
     * @param $idRecommendation
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(Request $request, $patientId, $idRecommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $recommendation = $patient->recommendations()->findOrFail($idRecommendation);
        $id = $request->input('id');
        $mealStore = $nutritionist->mealStore()->findOrFail($id);
        $recommendationRepository = new RecommendationRepository($recommendation);
        $newRecommendation = $recommendationRepository->addMenuToRecommendation($mealStore);
        return response()->json(['recommendation' => $newRecommendation], 200);
    }
    /**
     * get a menus posted by patient related  to recommendation
     *
     * @param int $patientId
     * @return JsonResponse
     * @throws \Exception
     */
    public function getPatientMenus($patientId)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $recommendation = $patient->recommendations()->orderBy('id', 'desc')->first();;
        $recommendationRepository = new RecommendationRepository($recommendation);
        $menus = $recommendationRepository->menusOfPatient();
        return response()->json(['menus' => $menus], 200);
    }
    /**
     * get a only one menu (with ingredients ) posted by patient related  to recommendation
     *
     * @param int $patientId
     * @param int $idMenu
     * @return JsonResponse
     */
    public function show($patientId,$idMenu)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        //TODO change to repo
        $recommendation = $patient->recommendations()->orderBy('id', 'desc')->first();
        $menus = $recommendation->menus()->findOrFail($idMenu);
        $menus['ingredients'] = $menus->ingredients;
        return response()->json(['menus' =>$menus ], 200);
    }
    /**
     * destroy  a menu related  to recommendation
     *
     * @param int $patientId
     * @param int $idRecommendation
     * @param int $idMenu
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($patientId, $idRecommendation, $idMenu)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $recommendation = $patient->recommendations()->findOrFail($idRecommendation);
        $recommendation->menus()->findOrFail($idMenu);
        $recommendationRepository = new RecommendationRepository($recommendation);
        $recommendationRepository->destroyMenu($idMenu);
        return response()->json(['success' => true,], 200);
    }

}
