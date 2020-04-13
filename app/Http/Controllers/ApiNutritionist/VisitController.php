<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\VisitRequest;
use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use Illuminate\Http\JsonResponse;

class VisitController extends Controller
{

    /**
     * Method for nutritionist to get all the visits related to a patient from database
     *
     * @param PaginationRequest $request
     * @param int $idPatient
     * @return JsonResponse
     */
    public function index(PaginationRequest $request, $idPatient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', null);
        $orderDirection = $request->input('orderDirection', 'asc');
        $patientRepository = new PatientRepository($patient);
        $visits = $patientRepository->paginateVisits($page, $perPage, $orderBy, $orderDirection);
        return response()->json(['data' => $visits], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VisitRequest $request
     * @param int $idPatient
     *
     * @return JsonResponse
     */
    public function store(VisitRequest $request, $idPatient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $weight = $request->input('weight');
        $note = $request->input('note');
        $belly = $request->input('belly');
        $chest = $request->input('chest');
        $legs = $request->input('legs');
        $neck = $request->input('neck');
        $tall = $request->input('tall');
        $scheduledAt = $request->input('scheduled_at');
        $doneAt = $request->input('done_at');
        $patientRepository = new PatientRepository($patient);
        $visit = $patientRepository->createVisit($weight, $note,$belly, $chest,$legs, $neck,$tall,$scheduledAt, $doneAt);
        return response()->json(['data' => $visit], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $idPatient
     * @param int $idVisit
     * @return JsonResponse
     */
    public function show($idPatient, $idVisit)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $visit = $patient->visits()->findOrFail($idVisit);
        return response()->json(['data' => $visit], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VisitRequest $request
     * @param int $idPatient
     * @param int $idVisit
     * @return JsonResponse
     */
    public function update(VisitRequest $request, $idPatient, $idVisit)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $visit = $patient->visits()->findOrFail($idVisit);
        $weight = $request->input('weight');
        $note = $request->input('note');
        $scheduledAt = $request->input('scheduled_at');
        $doneAt = $request->input('done_at');
        $visitRepository = new VisitRepository($visit);
        $visitUpdated = $visitRepository->updateVisit($weight, $note, $scheduledAt, $doneAt);
        return response()->json(['data' => $visitUpdated], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param $idPatient
     * @param $idVisit
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($idPatient, $idVisit)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $visit = $patient->visits()->findOrFail($idVisit);
        $visitRepository = new VisitRepository($visit);
        $visitRepository->deleteVisit();
        return response()->json(['data' => true], 200);
    }

}
