<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendationRequest;
use App\Repositories\MenuRepository;
use App\Repositories\PatientRepository;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{

    /**
     * Method for nutritionist to get all recommendation related to patient
     * @param $patientId
     * @return JsonResponse
     */
    public function index($patientId)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        return response()->json(['recommendations' => $patient->recommendations], 200);
    }

    /**
     * Method for nutritionist to create recommendation related to patient
     *
     * @param RecommendationRequest $request
     * @param $patientId
     * @return JsonResponse
     */
    public function store(RecommendationRequest $request, $patientId)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $avoid = $request->input('avoid');
        $name = $request->input('name');
        $patientRepository = new PatientRepository($patient);
        $recommendation = $patientRepository->createRecommendation($name, $avoid);
        return response()->json(['recommendation' => $recommendation], 200);
    }

    /**
     * Method for nutritionist to get only one recommendation related to patient
     *
     * @param int $patientId
     * @param int $idRecommendation
     * @return JsonResponse
     */
    public function show($patientId, $idRecommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $recommendation = $patient->recommendations()->findOrFail($idRecommendation);
        $recommendation['menu'] = $recommendation->menus;
        return response()->json(['recommendation' => $recommendation], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RecommendationRequest $request
     * @param int $patientId
     * @param int $idRecommendation
     * @return JsonResponse
     */
    public function update(RecommendationRequest $request, $patientId, $idRecommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $recommendation = $patient->recommendations()->findOrFail($idRecommendation);
        $avoid = $request->input('avoid');
        $name = $request->input('name');
        $recommendationRepository = new RecommendationRepository($recommendation);
        $recommendation = $recommendationRepository->updateRecommendation($name, $avoid);
        return response()->json(['recommendation' => $recommendation], 200);
    }

    /**
     * Method for nutritionist to delete recommendation related to patient
     *
     * @param int $patientId
     * @param int $idRecommendation
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($patientId, $idRecommendation)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $recommendation = $patient->recommendations()->findOrFail($idRecommendation);
        $recommendationRepository = new RecommendationRepository($recommendation);
        $recommendationRepository->deleteRecommendation();
        return response()->json(['success' => true], 200);
    }






}
