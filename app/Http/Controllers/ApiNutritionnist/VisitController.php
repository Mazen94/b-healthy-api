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
     * @param $idPatient
     * @return JsonResponse
     */
    public function index($idPatient)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($idPatient);
        $visits = $patient->visits()->paginate();
        return response()->json(['visits' => $visits], 200);
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
        $scheduledAt = $request->input('scheduled_at');
        $doneAt = $request->input('done_at');
        $visitRepository = new VisitRepository($patient);
        $visit = $visitRepository->createVisit($weight, $note, $scheduledAt, $doneAt);
        return response()->json(['visits' => $visit], 200);
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
        return response()->json(['visit' => $visit], 200);
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
        return response()->json(['visit' => $visitUpdated], 200);
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
        return response()->json(['success' => true], 200);
    }

}
