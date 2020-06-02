<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class PatientStatsController extends Controller
{
    /**
     * get the weight , legs , belly and chest progression per month
     * @param int $patientId
     * @return mixed
     */
    public function getStatisticalOfPatient($patientId)
    {
        $nutritionist = auth()->user();
        $patient = $nutritionist->patients()->findOrFail($patientId);
        $patientRepository = new PatientRepository($patient);
        $data['weights'] = $patientRepository->weightAndMonth();
        $data['legs'] = $patientRepository->legsAndMonth();
        $data['belly'] = $patientRepository->bellyAndMonth();
        $data['chest'] = $patientRepository->chestAndMonth();
        return response()->json(['data' => $data], 200);
    }
}
