<?php

namespace App\Http\Controllers\ApiPatient;

use App\Activitephysique;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhysicalActivityRequest;
use App\Repositories\PhysicalActiviteRepository;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class PhysicalActiviteController extends Controller
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

        $activity = PhysicalActiviteRepository::createActivity(
            $patient,
            $request->input('distance'),
            $request->input('activite_type'),
            $request->input('energy_burned'),
            $request->input('duration')
        );

        return response()->json(
            [
                'success' => true,
                'activity' => $activity,
            ],
            200
        );
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
        return response()->json(
            [
                'success' => true,
                'activity' => $patient->physicalActivity,
            ],
            200
        );
    }

}
