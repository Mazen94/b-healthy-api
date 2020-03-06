<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPatient;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */
    public function index()
    {
        $patientRepository = new PatientRepository(JWTAuth::parseToken()->authenticate());
        $patients = $patientRepository->getAllPatients();
        return response()->json(
            [
                'success' => true,
                'patients' => $patients,
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return JsonResponse
     */
    public function store(RegisterPatient $request)
    {
        $patientRepository = new PatientRepository(JWTAuth::parseToken()->authenticate());
        $patient = $patientRepository->createPatient($request);
        if (empty($patient)) {
            return response()->json(
                [
                    'success' => false,
                    'patient' => 'Error to create patient',
                ],
                400
            );
        }
        return response()->json(
            [
                'success' => true,
                'patient' => $patient,
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $patientRepository = new PatientRepository(JWTAuth::parseToken()->authenticate());
        $patient = $patientRepository->getPatient($id);
        return response()->json(
            [
                'success' => true,
                'patient' => $patient,
            ],
            200
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $patientRepository = new PatientRepository(JWTAuth::parseToken()->authenticate());
        $patientRepository->deletePatient($id);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }
}
