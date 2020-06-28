<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\NutritionistCreateRequest;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Config;

class AuthController extends Controller
{
    /**
     * Nutritionist Register
     * @param NutritionistCreateRequest $request
     * @return JsonResponse
     */
    public function register(NutritionistCreateRequest $request)
    {
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $password = $request->input('password');
        $photo = config('constants.IMAGE_NUTRITIONIST');
        $nutritionist = NutritionistRepository::register($email, $firstName, $lastName, $password, $photo);
        $token = JWTAuth::fromUser($nutritionist);
        return response()->json(['token' => $token,], 200);
    }

    /**
     * Login Nutritionist
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => __('messages.login')], 401);
        }
        $data['token'] = $token;
        $data['status'] = auth('api')->user()->status;
        return response()->json(['data' => $data,], 200);
    }
}
