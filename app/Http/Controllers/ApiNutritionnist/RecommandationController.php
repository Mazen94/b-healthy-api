<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRecommendationRequest;
use App\Http\Requests\PutRecommendationRequest;
use App\Repositories\RecommandationRepository;

use JWTAuth;

class RecommandationController extends Controller
{
    protected $recommandationRepository;
    protected $nutritionist;

    /**
     * PatientController constructor.
     * @param RecommandationRepository $recommandationRepository
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function __construct(RecommandationRepository $recommandationRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->recommandationRepository = new RecommandationRepository($this->nutritionist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $recommandations = $this->recommandationRepository->getAllRecommendations($id);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRecommendationRequest $request, $id_patient)
    {
        $recommandation = $this->recommandationRepository->createRecommendation($request, $id_patient);
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($patient_id, $id_recommendation)
    {
        $recommandation = $this->recommandationRepository->getRecommendation($patient_id, $id_recommendation);
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PutRecommendationRequest $request, $patient_id, $id_recommendation)
    {
        $recommandation = $this->recommandationRepository->updateRecommendation(
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($patient_id, $id_recommendation)
    {
        if ($this->recommandationRepository->deleteRecommendation($patient_id, $id_recommendation)) {
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
