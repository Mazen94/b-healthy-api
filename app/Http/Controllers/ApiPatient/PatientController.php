<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\PatientUpdateRequest;
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
     * @param PatientUpdateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(PatientUpdateRequest $request)
    {
        $patientConnected = auth()->user();
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $gender = $request->input('gender');
        $numberPhone = $request->input('numberPhone');
        $profession = $request->input('profession');
        $age = $request->input('age');
        $patientRepository = new PatientRepository($patientConnected);
        $patient = $patientRepository->updatePatient(
            $email,
            $firstName,
            $lastName,
            $gender,
            $numberPhone,
            $profession,
            $age
        );
        return response()->json(['patient' => $patient], 200);
    }

    /**
     * Method to change the password
     * @param ChangePasswordRequest $request
     * @return mixed
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $patientConnected = auth()->user();
        $newPassword = $request->input('newPassword');
        $password = $request->input('password');
        if(password_verify($password,$patientConnected->password)){
            $patientRepository = new PatientRepository($patientConnected);
            return response()->json(['data' =>  $patientRepository->changePassword($password,$newPassword)], 200);
        }
        return response()->json(['data' => __('messages.changePassword')], 401);
    }

}
