<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use App\Visit;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    public function getWeightMonth()
    {
        $patient = auth()->user();
        $patientRepository = new PatientRepository($patient);
        $weights = $patientRepository->weightAndMonth();
        return response()->json(['data' => $weights], 200);
    }
}

