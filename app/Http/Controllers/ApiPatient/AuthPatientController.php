<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthPatientController extends Controller
{
    /**
     * Login Patient
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        if (!$token = auth('api-patient')->attempt($credentials)) {
            return response()->json(
                [
                    'response' => 'error',
                    'message' => 'invalid_email_or_password',
                ]
            );
        }


        return response()->json(
            [
                'response' => 'success',
                'result' => [
                    'token' => $token,
                ],
            ]
        );
    }
}
