<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitPostRequest;
use App\Http\Requests\VisitPutRequest;
use App\Repositories\VisitRepository;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class VisitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id_patient
     * @return JsonResponse
     */
    public function index($id_patient)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $visitRepository = new VisitRepository($nutritionist);
        $visits = $visitRepository->getAllVisits($id_patient);
        return response()->json(
            [
                'success' => true,
                'visits' => $visits,
            ],
            200
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param VisitPostRequest $request
     * @param $id_patient
     *
     * @return JsonResponse
     */
    public function store(VisitPostRequest $request, $id_patient)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $visitRepository = new VisitRepository($nutritionist);
        $visit = $visitRepository->createVisit($request, $id_patient);
        return response()->json(
            [
                'success' => true,
                'visits' => $visit,
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id_patient
     * @param int $id_visit
     * @return JsonResponse
     */
    public function show($id_patient, $id_visit)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $visitRepository = new VisitRepository($nutritionist);
        $visit = $visitRepository->getVisit($id_patient, $id_visit);
        return response()->json(
            [
                'success' => true,
                'visit' => $visit,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VisitPostRequest $request
     * @param int $id_patient
     * @param int $id_visit
     * @return JsonResponse
     */
    public function update(VisitPostRequest $request, $id_patient, $id_visit)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $visitRepository = new VisitRepository($nutritionist);
        $visit = $visitRepository->updateVisit($request, $id_patient, $id_visit);
        return response()->json(
            [
                'success' => true,
                'visit' => $visit
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param $id_patient
     * @param $id_visit
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id_patient, $id_visit)
    {
        $nutritionist = JWTAuth::parseToken()->authenticate();
        $visitRepository = new VisitRepository($nutritionist);
        $visitRepository->deleteVisit($id_patient, $id_visit);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

}
