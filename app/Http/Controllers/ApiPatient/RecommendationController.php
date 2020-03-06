<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\RecommandationRepository;
use JWTAuth;

class RecommendationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($patient);
        $recommendation = $recommandationRepository->getRecommendationByPatient();
        return response()->json(
            [
                'success' => true,
                'recommandations' => $recommendation,
            ],
            200
        );
    }

    /**
     * Display a listing of the resource.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexMenus()
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($patient);
        $recommendation = $recommandationRepository->getRecommendationMenusByPatient();
        return response()->json(
            [
                'success' => true,
                'recommandations' => $recommendation,
            ],
            200
        );
    }
}
