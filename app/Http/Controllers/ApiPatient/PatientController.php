<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\RegisterPatient;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;

class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JWTAuth::parseToken()->authenticate();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PatientRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(PatientRequest $request)
    {
        $patientConnected = auth()->user();
        $patient = PatientRepository::updatePatient(
            $patientConnected,
            $request->input('email'),
            $request->input('firstName'),
            $request->input('lastName'),
            $request->input('gender'),
            $request->input('numberPhone'),
            $request->input('profession')
        );
        return response()->json(
            [
                'success' => true,
                'patient' => $patient,
            ],
            200
        );
    }


}
