<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhysicalActivityRequest;
use App\Repositories\PhysicalActiviteRepository;
use JWTAuth;

class PhysicalActiviteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param PhysicalActivityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PhysicalActivityRequest $request)
    {
        $patient = auth()->user();
        $activityRepository = new PhysicalActiviteRepository($patient);
        $activity = $activityRepository->createActivity($request);
        if ($activity) {
            return response()->json(
                [
                    'success' => true,
                    'activity' => $activity,
                ],
                200
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param PhysicalActivityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $patient = JWTAuth::parseToken()->authenticate();
        $activityRepository = new PhysicalActiviteRepository($patient);
        $activitys = $activityRepository->getActivitys();

        return response()->json(
            [
                'success' => true,
                'activity' => $activitys,
            ],
            200
        );
    }

}
