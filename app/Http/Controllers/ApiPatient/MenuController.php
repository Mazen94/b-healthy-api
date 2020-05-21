<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Menu;
use App\Repositories\MenuRepository;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;


class MenuController extends Controller
{
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
       $menu['ingredients'] = $menu->ingredients;



        $menu['checkMenu'] = MenuRepository::checkMenuByDateMenuType($menu->type_menu);
        return response()->json(['data' => $menu], 200);
    }

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
        $menu = MenuRepository::createMenu($name, $typeMenu, $calorie, $recommendation);
        return response()->json(['data' => $menu,], 200);
    }

    /**
     * get the menus created by patient today
     * @return mixed
     */
    public function getMenuByDate()
    {
        $patient = auth()->user();
        $menus = MenuRepository::getMenuByCurrentDate($patient);
        return response()->json(['data' => $menus,], 200);
    }


}
