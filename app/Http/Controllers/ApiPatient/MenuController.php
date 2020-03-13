<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Repositories\MenuRepository;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;


class MenuController extends Controller
{
    /**
     * Store a newly created menu in storage and give this menu to the recommendation.
     *
     * @param MenuRequest $request
     * @param int $idRecommendation
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(MenuRequest $request, $idRecommendation)
    {
        $patient = auth()->user();
        $recommendation = $patient->recommendations()->findOrFail($idRecommendation);
        $name = $request->input('name');
        $typeMenu = $request->input('type_menu');
        $calorie = $request->input('calorie');
        $menuRepository = new MenuRepository();
        $menu = $menuRepository->createMenu($name, $typeMenu, $calorie);
        $recommendationRepository = new RecommendationRepository($recommendation);
        $recommendationRepository->addMenuToRecommendation($menu->id);
        return response()->json(['menu' => $menu,], 200);
    }

}
