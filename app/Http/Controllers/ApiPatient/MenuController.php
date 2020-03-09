<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Repositories\MenuRepository;
use JWTAuth;

class MenuController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuRequest $request,$id_recommendation)
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $menuRepository = new MenuRepository($patient);
        $menu = $menuRepository->createMenu($request,$id_recommendation);
        if ($menu) {
            return response()->json(
                [
                    'success' => true,
                    'menu' => $menu,
                ],
                200
            );
        }
    }
}
