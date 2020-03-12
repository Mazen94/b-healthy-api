<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\RecommandationRepository;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class RecommendationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param $id
     * @return JsonResponse
     */
    public function index()
    {
        $patient = auth()->user();
        $recommendationRepository = new RecommendationRepository();
        $recommendation = $recommendationRepository->getRecommendationByPatient($patient);
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
        $recommendationRepository = new RecommendationRepository();
        $menus = $recommendationRepository->getRecommendationMenusByPatient($patient);
        return response()->json(['Menus' => $menus,], 200);
    }
}
