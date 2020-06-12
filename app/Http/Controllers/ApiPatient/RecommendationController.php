<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class RecommendationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getLastRecommendation()
    {
        $patient = auth()->user();
        $patientRepository = new PatientRepository($patient);
        $recommendation = $patientRepository->getRecommendationByPatient();
        return response()->json(['data' => $recommendation,], 200);
    }


}
