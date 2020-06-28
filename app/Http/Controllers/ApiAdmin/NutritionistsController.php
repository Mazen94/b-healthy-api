<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Nutritionist;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;

class NutritionistsController extends Controller
{
    /**
     * Method to get all nutritionist related to nutritionist
     *
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function index(PaginationRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDirection = $request->input('orderDirection', 'desc');
        $nutritionists = AdminRepository::paginateNutritionists($page, $perPage, $orderBy, $orderDirection);
        return response()->json(['data' => $nutritionists], 200);
    }

    /**
     *
     *
     * @param $id
     * @return JsonResponse
     */
    public function activate($id)
    {
        $nutritionist = Nutritionist::findOrFail($id);
        $nutritionist->status = 1;
        $nutritionist->save();
        return response()->json(['data' => $nutritionist], 200);
    }


    /**
     *
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $nutritionist = Nutritionist::findOrFail($id);
        $nutritionist->delete();
        return response()->json(['data' => true], 200);
    }
}
