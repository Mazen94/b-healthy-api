<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;


class PatientController extends Controller
{

    /**
     * Method to get all patients related to nutritionist
     *
     * @return JsonResponse
     *
     */
    public function index()
    {
        $nutritionist = auth()->user();
        $patients = $nutritionist->patients()->paginate();
        return response()->json(
            [
                'success' => true,
                'patients' => $patients,
            ],
            200
        );
    }

    /**
     * Method to create a new patient related to patient
     *
     * @param PatientRequest $request
     * @return JsonResponse
     */
    public function store(PatientRequest $request)
    {
        $nutritionist = auth()->user();
        $patient = PatientRepository::createPatient(
            $nutritionist,
            $request->input('email'),
            $request->input('firstName'),
            $request->input('lastName'),
            $request->input('password'),
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

    /**
     * Display the specified patient related to nutritionist.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id);
        return response()->json(
            [
                'success' => true,
                'patient' => $patient,
            ],
            200
        );
    }


    /**
     * Remove patient related to nutritionist from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id);
        PatientRepository::deletePatient($patient);
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }
}
