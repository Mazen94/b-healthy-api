<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\RegisterPatient;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;

class PatientController extends Controller
{
    /**
     * Login Patient
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        if (!$token = auth('api-patient')->attempt($credentials)) {
            return response()->json(
                [
                    'response' => 'error',
                    'message' => 'invalid_email_or_password',
                ]
            );
        }


        return response()->json(
            [
                'response' => 'success',

                'token' => $token,

            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            [
                'success' => true,
                'patient' => auth()->user(),
            ],
            200
        );
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
