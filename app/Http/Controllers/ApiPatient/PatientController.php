<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $patientRepository = new PatientRepository(JWTAuth::parseToken()->authenticate());
        $patient = $patientRepository->updatePatient($request);
        return response()->json(
            [
                'success' => true,
                'nutritionist' => $patient,
            ],
            200
        );
    }


}
