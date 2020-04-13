<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\PatientRequest;
use App\Repositories\NutritionistRepository;
use App\Repositories\PatientRepository;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\JsonResponse;


class PatientController extends Controller
{

    /**
     * Method to get all patients related to nutritionist
     *
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function index(PaginationRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', null);
        $orderDirection = $request->input('orderDirection', 'asc');
        $search =$request->input('search', '');
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $patients = $nutritionistRepository->paginatePatient($page, $perPage, $orderBy, $orderDirection,$search);
        return response()->json(['data' => $patients], 200);
    }

    /**
     * Method to create a new patient related to patient
     *
     * @param PatientRequest $request
     * @return JsonResponse
     */
    public function store(PatientRequest $request)
    {
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $password = $request->input('password');
        $gender = $request->input('gender');
        $numberPhone = $request->input('numberPhone');
        $profession = $request->input('profession');
        $age = $request->input('age');
        $nutritionist = auth()->user();
        $nutritionistRepository = new NutritionistRepository($nutritionist);
        $patient = $nutritionistRepository->createPatient(
            $email,
            $firstName,
            $lastName,
            $password,
            $gender,
            $numberPhone,
            $profession,
            $age
        );
        return response()->json(['data' => $patient], 200);
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
        return response()->json(['data' => $patient], 200);
    }


    /**
     * Remove patient with recommendations related to nutritionist from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($id);
        $patientRepository = new PatientRepository($patient);
        $patientRepository->deletePatient();
        return response()->json(['data' => true], 200);
    }
}
