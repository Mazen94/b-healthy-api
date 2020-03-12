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
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['patient' => auth()->user()], 200);
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
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $gender = $request->input('gender');
        $numberPhone = $request->input('numberPhone');
        $profession = $request->input('profession');
        $patientRepository = new PatientRepository($patientConnected);
        $patient = $patientRepository->updatePatient(
            $email,
            $firstName,
            $lastName,
            $gender,
            $numberPhone,
            $profession
        );
        return response()->json(['patient' => $patient], 200);
    }


}
