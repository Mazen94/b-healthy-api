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
     * @param int $id_recommendation
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(MenuRequest $request, $id_recommendation)
    {
        $patient = auth()->user();
        $recommendation = $patient->recommandations()->findOrFail($id_recommendation);
        $menu = MenuRepository::createMenu(
            $request->input('name'),
            $request->input('type_menu'),
            $request->input('calorie')
        );
        RecommendationRepository::addMenuToRecommendation($recommendation, $menu->id);
        return response()->json(
            [
                'success' => true,
                'menu' => $menu,
            ],
            200
        );
    }

}
