<?php

namespace App\Http\Controllers\ApiPatient;


use App\Http\Controllers\Controller;
use App\Http\Requests\PhysicalActivityRequest;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;


class PhysicalActivityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param PhysicalActivityRequest $request
     * @return JsonResponse
     */
    public function store(PhysicalActivityRequest $request)
    {
        $patient = auth()->user();
        $distance = $request->input('distance');
        $activityType = $request->input('typical_activity');
        $energyBurned = $request->input('energy_burned');
        $duration = $request->input('duration');
        $patientRepository = new PatientRepository($patient);
        $activity = $patientRepository->createActivity($distance, $activityType, $energyBurned, $duration);
        return response()->json(['activity' => $activity,], 200);
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @return JsonResponse
     */
    public function index()
    {
        $patient = auth()->user();
        return response()->json(['activity' => $patient->physicalActivity,], 200);
    }

}
