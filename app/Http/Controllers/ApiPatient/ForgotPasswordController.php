<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Patient;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendNewPassword(Request $request)
    {
        $patient = Patient::where('email', $request->email)->first();
        if (!empty($patient)) {
            $patientRepository = new PatientRepository($patient);
            $password = Str::random(8);
            $patient = $patientRepository->updatePatient(
                $patient->email,
                $patient->firstName,
                $patient->lastName,
                $patient->gender,
                $patient->numberPhone,
                $patient->profession,
                $patient->age,
                $password
            );
            Mail::to($request->email)->send(new ForgotPassword($password));
            return response()->json(['data' => $patient], 200);
        } else {
            return response()->json(['data' => __('messages.emailFailed')], 404);
        }
    }

}
