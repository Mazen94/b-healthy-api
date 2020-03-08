<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreMenuRequest;
use App\Http\Requests\PutStoreMenuRequest;
use App\Repositories\StoreMenuRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return JsonResponse
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
     * Display the specified StoreMenu with these ingredients by age .
     *
     * @param int $age
     * @return JsonResponse
     */
    public function showByAge(Request $request)
    {
        $storeMenuWithIngredients = $this->storeMenuRepository->getStoreMenuWithIngredientsByAge($request->age);
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
     * @return JsonResponse
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
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($this->storeMenuRepository->deleteStoreMenu($id)) {
            return response()->json(
                [
                    'success' => true,
                ],
                200
            );
        }
    }

    /**
     * add ingredient to the storeMenu.
     *
     * @param int $id_storeMenu
     * @param $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function addIngredient(Request $request, $id_storeMenu)
    {
        $storeMenu = $this->storeMenuRepository->addIngredientToStoreMenu($request, $id_storeMenu);
        return response()->json(
            [
                'success' => true,
                'storeMenu' => $storeMenu,
            ],
            200
        );
    }

    /**
     * delete ingredient to the storeMenu.
     *
     * @param int $id_storeMenu
     * @param int $id_ingredient
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteIngredient($id_storeMenu, $id_ingredient)
    {
        if ($this->storeMenuRepository->deleteIngredientToStoreMenu($id_storeMenu, $id_ingredient)) {
            return response()->json(
                [
                    'success' => true,
                    'ingredient' => 'deleted',
                ],
                200
            );
        }
    }

    /**
     * update amount ingredient to the storeMenu.
     *
     * @param int $id_storeMenu
     * @param int $id_ingredient
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateIngredient(Request $request, $id_storeMenu, $id_ingredient)
    {
        $menuUpdated = $this->storeMenuRepository->updateIngredientToStoreMenu(
            $request,
            $id_storeMenu,
            $id_ingredient
        );
        return response()->json(
            [
                'success' => $menuUpdated,
            ],
            200
        );
    }

}
