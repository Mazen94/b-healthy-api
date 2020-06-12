<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * get measures in the last visit
     * @return mixed
     */
   public function getLastVisit() {
       $patient = auth()->user();
       $visits = $patient->visits()->latest()->first();
       return response()->json(['data' => $visits,], 200);
   }
}
