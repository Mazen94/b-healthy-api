<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPatient;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use JWTAuth;

class PatientController extends Controller
{
    protected $patientRepository;
    protected $nutritionist;

    /**
     * PatientController constructor.
     * @param PatientRepository $patientRepository
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function __construct(PatientRepository $patientRepository)
    {
        $this->nutritionist = JWTAuth::parseToken()->authenticate();
        $this->patientRepository = new PatientRepository($this->nutritionist);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index()
    {
        $patients = $this->patientRepository->getAllPatients();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterPatient $request)
    {
       $patient = $this->patientRepository->createPatient($request);
       if(empty($patient)){
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $patient = $this->patientRepository->getPatient($id);
        if (empty($patient)) {
            return response()->json(
                [
                    'success' => false,
                    'patient' => 'Not Found',
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
       if( $this->patientRepository->deletePatient($id)){
           return response()->json(
               [
                   'success' => true,
                   'patient' => 'deleted',
               ],
               200
           );
       }
        return response()->json(
            [
                'success' => false,
                'patient' => 'Cannot delete this patient',
            ],
            400
        );
    }
}
