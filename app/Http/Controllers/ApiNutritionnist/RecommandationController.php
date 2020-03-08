<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRecommendationRequest;
use App\Http\Requests\PutRecommendationRequest;
use App\Repositories\RecommandationRepository;

use Illuminate\Http\Request;
use JWTAuth;

class RecommandationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        $recommandations = $recommandationRepository->getAllRecommendations($id);
        return response()->json(
            [
                'success' => true,
                'recommandations' => $recommandations,
            ],
            200
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PostRecommendationRequest $request
     * @param $id_patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRecommendationRequest $request, $id_patient)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        $recommandation = $recommandationRepository->createRecommendation($request, $id_patient);
        return response()->json(
            [
                'success' => true,
                'recommandation' => $recommandation,
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $patient_id
     * @param $id_recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($patient_id, $id_recommendation)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        $recommandation = $recommandationRepository->getRecommendation($patient_id, $id_recommendation);
        return response()->json(
            [
                'success' => true,
                'recommandation' => $recommandation,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $patient_id
     * @param $id_recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PutRecommendationRequest $request, $patient_id, $id_recommendation)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        $recommandation = $recommandationRepository->updateRecommendation(
            $request,
            $patient_id,
            $id_recommendation
        );
        return response()->json(
            [
                'success' => true,
                'recommandation' => $recommandation,
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $patient_id
     * @param $id_recommendation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($patient_id, $id_recommendation)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        if ($recommandationRepository->deleteRecommendation($patient_id, $id_recommendation)) {
            return response()->json(
                [
                    'success' => true,
                    'storeMenu' => 'deleted',
                ],
                200
            );
        }
    }

    /**
     * add a menu to a recommendation
     *
     * @param Request $request
     * @param int $patient_id
     * @param $id_recommendation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function storeMenu(Request $request, $patient_id, $id_recommendation)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        $recommendation = $recommandationRepository->storeMenu($request, $patient_id, $id_recommendation);
        return response()->json(
            [
                'success' => true,
                'recommendation' => $recommendation,
            ],
            200
        );
    }


    /**
     * destroy  a menu related  to recommendation
     *
     * @param Request $request
     * @param int $patient_id
     * @param $id_recommendation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroyMenu($patient_id, $id_recommendation, $id_menu)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $recommandationRepository = new RecommandationRepository($nutritionist);
        $recommandationRepository->destroyMenu($patient_id, $id_recommendation, $id_menu);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }


}
