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
        return response()->json(['recommendation' => $recommendation,], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexMenus()
    {
        $patient = auth()->user();
        $patientRepository = new PatientRepository($patient);
        $menus = $patientRepository->getRecommendationMenusByPatient();
        return response()->json(['Menus' => $menus,], 200);
    }

}
