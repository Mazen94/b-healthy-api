<?php

namespace App\Http\Controllers\ApiPatient;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login Patient
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        if (!$token = auth('api-patient')->attempt($credentials)) {
            return response()->json(['message' => __('messages.login')], 401);
        } else {
            $data['token'] = $token;
            $data['id'] = auth('api-patient')->user()->id;
            return response()->json(['data' => $data], 200);
        }
    }
}
