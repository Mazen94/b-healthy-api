<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitPostRequest;
use App\Http\Requests\VisitPutRequest;
use App\Repositories\VisitRepository;
use JWTAuth;

class VisitController extends Controller
{

    protected $visitRepository;
    protected $nutritionist;

    /**
     * PatientController constructor.
     * @param PatientRepository $patientRepository
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function __construct(VisitRepository $visitRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->visitRepository = new VisitRepository($this->nutritionist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id_patient)
    {
        $visits = $this->visitRepository->getAllVisits($id_patient);
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
     * @param \Illuminate\Http\Request $request
     * @param $id_patient
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VisitPostRequest $request,$id_patient)
    {
        $visit = $this->visitRepository->createVisit($request,$id_patient);
        if (empty($visit)) {
            return response()->json(
                [
                    'success' => false,
                    'ingredient' => 'Error to create ingredient',
                ],
                400
            );
        }
        return response()->json(
            [
                'success' => true,
                'ingredient' => $visit,
            ],
            200
        );

    }

    /**
     * Display the specified resource.
     *
     * @param int $id_patient
     * @param int $id_visit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id_patient,$id_visit)
    {
        $visit = $this->visitRepository->getVisit($id_patient,$id_visit);
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
     * @param \Illuminate\Http\Request $request
     * @param int $id_patient
     * @param int $id_visit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(VisitPutRequest $request, $id_patient,$id_visit)
    {
        $visit = $this->visitRepository->updateVisit($request, $id_patient,$id_visit);
        return response()->json(
            [
                'success' => $visit,
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param $id_patient
     * @param $id_visit
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id_patient,$id_visit)
    {
        if ($this->visitRepository->deleteVisit($id_patient,$id_visit)) {
            return response()->json(
                [
                    'success' => true,
                    'ingredient' => 'deleted',
                ],
                200
            );
        }
    }
}
