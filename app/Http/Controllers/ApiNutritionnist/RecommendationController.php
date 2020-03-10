<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendationRequest;
use App\Recommandation;
use App\Repositories\MenuRepository;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RecommendationController extends Controller
{

    /**
     * Method for nutritionist to get all recommendation related to patient
     * @param $id
     * @return JsonResponse
     */
    public function index($id)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id);
        return response()->json(
            [
                'success' => true,
                'recommandations' => $patient->recommendations,
            ],
            200
        );
    }

    /**
     * Method for nutritionist to create recommendation related to patient
     *
     * @param RecommendationRequest $request
     * @param $id_patient
     * @return JsonResponse
     */
    public function store(RecommendationRequest $request, $id_patient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id_patient);
        $recommendation = RecommendationRepository::createRecommendation($patient, $request->input('avoid'));
        return response()->json(
            [
                'success' => true,
                'recommandation' => $recommendation,
            ],
            200
        );
    }

    /**
     * Method for nutritionist to get only one recommendation related to patient
     *
     * @param int $patient_id
     * @param int $id_recommendation
     * @return JsonResponse
     */
    public function show($patient_id, $id_recommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommendations()->findOrFail($id_recommendation);
        return response()->json(
            [
                'success' => true,
                'recommendation' => $recommendation,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RecommendationRequest $request
     * @param int $patient_id
     * @param int $id_recommendation
     * @return JsonResponse
     */
    public function update(RecommendationRequest $request, $patient_id, $id_recommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommendations()->findOrFail($id_recommendation);
        $recommendation = RecommendationRepository::updateRecommendation($recommendation, $request->input('avoid'));
        return response()->json(
            [
                'success' => true,
                'recommendation' => $recommendation,
            ],
            200
        );
    }

    /**
     * Method for nutritionist to delete recommendation related to patient
     *
     * @param int $patient_id
     * @param int $id_recommendation
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($patient_id, $id_recommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommendations()->findOrFail($id_recommendation);
        RecommendationRepository::deleteRecommendation($recommendation);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

    /**
     * add a menu to a recommendation
     * this recommendation related to patient
     *
     * @param Request $request
     * @param int $patient_id
     * @param $id_recommendation
     * @return JsonResponse
     * @throws \Exception
     */
    public function addMenuToRecommendation(Request $request, $patient_id, $id_recommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommendations()->findOrFail($id_recommendation);
        $id_menu = MenuRepository::createMenuWithIngredients(
            $request->input('StoreMenu.name'),
            $request->input('StoreMenu.calorie'),
            $request->input('StoreMenu.type_menu'),
            $request->input('StoreMenu.ingredients')
        );
        $newRecommendation = RecommendationRepository::addMenuToRecommendation($recommendation, $id_menu);
        return response()->json(
            [
                'success' => true,
                'recommendation' => $newRecommendation,
            ],
            200
        );
    }


    /**
     * destroy  a menu related  to recommendation
     *
     * @param int $patient_id
     * @param int $id_recommendation
     * @param int $id_menu
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroyMenu($patient_id, $id_recommendation, $id_menu)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patient_id);
        $recommendation = $patient->recommendations()->findOrFail($id_recommendation);
        $recommendation->menus()->findOrFail($id_menu);
        RecommendationRepository::destroyMenu($recommendation, $id_menu);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }


}
