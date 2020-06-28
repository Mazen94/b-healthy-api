<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login Nutritionist
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api-admin')->attempt($credentials)) {
            return response()->json(['message' => __('messages.login')], 401);
        }
        return response()->json(['token' => $token,], 200);
    }
}
