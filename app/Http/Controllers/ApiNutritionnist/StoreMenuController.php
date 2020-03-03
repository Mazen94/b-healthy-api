<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreMenuRequest;
use App\Http\Requests\PutStoreMenuRequest;
use App\Repositories\StoreMenuRepository;
use JWTAuth;

class StoreMenuController extends Controller
{
    protected $nutritionist;
    protected $storeMenuRepository;

    /**
     * PatientController constructor.
     * @param StoreMenuRepository $storeMenuRepositoryitory
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function __construct(StoreMenuRepository $storeMenuRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->storeMenuRepository = new StoreMenuRepository($this->nutritionist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $storeMenu = $this->storeMenuRepository->getAllStoreMenus();
        return response()->json(
            [
                'success' => true,
                'Storemenus' => $storeMenu,
            ],
            200
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostStoreMenuRequest $request)
    {
        $storeMenu = $this->storeMenuRepository->createStoreMenu($request);
        if (empty($storeMenu)) {
            return response()->json(
                [
                    'success' => false,
                    'StoreMenu' => 'Error to create ingredient',
                ],
                400
            );
        }
        return response()->json(
            [
                'success' => true,
                'StoreMenu' => $storeMenu,
            ],
            200
        );
    }

    /**
     * Display the specified StoreMenu with these ingredients.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $storeMenuWithIngredients = $this->storeMenuRepository->getStoreMenuWithIngredients($id);
        return response()->json(
            [
                'success' => true,
                'Storemenu' => $storeMenuWithIngredients,
            ],
            200
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PutStoreMenuRequest $request, $id)
    {
        $menuUpdated = $this->storeMenuRepository->updateStoreMenu($request, $id);
        return response()->json(
            [
                'success' => $menuUpdated,
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->storeMenuRepository->deleteStoreMenu($id)) {
            return response()->json(
                [
                    'success' => true,
                    'storeMenu' => 'deleted',
                ],
                200
            );
        }
    }
}
