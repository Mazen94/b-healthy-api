<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\RecommandationRepository;
use App\Repositories\RecommendationRepository;
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
        $patient = auth()->user();
        $recommendation = RecommendationRepository::getRecommendationByPatient($patient);
        return response()->json(
            [
                'success' => true,
                'recommandation' => $recommendation,
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
        $patient = auth()->user();
        $menus = RecommendationRepository::getRecommendationMenusByPatient($patient);
        return response()->json(
            [
                'success' => true,
                'Menus' => $menus,
            ],
            200
        );
    }
}
