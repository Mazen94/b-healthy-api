<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitPostRequest;
use App\Http\Requests\VisitPutRequest;
use App\Http\Requests\VisitRequest;
use App\Repositories\VisitRepository;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class VisitController extends Controller
{

    /**
     * Method for nutritionist to get all the visits related to a patient from database
     *
     * @param $id_patient
     * @return JsonResponse
     */
    public function index($id_patient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id_patient);
        $visits = $patient->visits()->paginate();
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
     * @param VisitRequest $request
     * @param $id_patient
     *
     * @return JsonResponse
     */
    public function store(VisitRequest $request, $id_patient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id_patient);
        $visit = VisitRepository::createVisit(
            $patient,
            $request->input('weight'),
            $request->input('note'),
            $request->input('scheduled_at'),
            $request->input('done_at')
        );
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
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
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
     * @param VisitRequest $request
     * @param int $id_patient
     * @param int $id_visit
     * @return JsonResponse
     */
    public function update(VisitRequest $request, $id_patient, $id_visit)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        $visitUpdated = VisitRepository::updateVisit(
            $visit,
            $request->input('weight'),
            $request->input('note'),
            $request->input('scheduled_at'),
            $request->input('done_at')
        );
        return response()->json(
            [
                'success' => true,
                'visit' => $visitUpdated
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
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id_patient);
        $visit = $patient->visits()->findOrFail($id_visit);
        VisitRepository::deleteVisit($visit);
        
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

}
