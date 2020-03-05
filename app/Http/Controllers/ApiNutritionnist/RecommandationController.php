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
    protected $recommandationRepository;
    protected $nutritionist;

    /**
     * PatientController constructor.
     * @param RecommandationRepository $recommandationRepository
     *
     */
    public function __construct(RecommandationRepository $recommandationRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->recommandationRepository = new RecommandationRepository($this->nutritionist);
    }

    /**
     * Display a listing of the resource.
     * @param $id
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
     * @param PostRecommendationRequest $request
     * @param $id_patient
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
     * @param int $patient_id
     * @param $id_recommendation
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
     * @param int $patient_id
     * @param $id_recommendation
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
     * @param int $patient_id
     * @param $id_recommendation
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

    /**
     * add a menu to a recommendation
     *
     * @param Request $request
     * @param int $patient_id
     * @param $id_recommendation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function storeMenu(Request $request,$patient_id, $id_recommendation)
    {
        $recommendation = $this->recommandationRepository->storeMenu($request,$patient_id, $id_recommendation);
            return response()->json(
                [
                    'success' => true,
                    'storeMenu' => $recommendation,
                ],
                200
            );
    }


}
