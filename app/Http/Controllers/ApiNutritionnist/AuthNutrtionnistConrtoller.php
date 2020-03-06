<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterNutritionist;
use App\Repositories\AuthNutrtionnistRepository;
use Illuminate\Http\Request;
use JWTAuth;


class AuthNutrtionnistConrtoller extends Controller
{
    protected $authNutrtionistRepository;

    /**
     * AuthNutrtionnistConrtoller constructor.
     */
    public function __construct()
    {
        $this->authNutrtionistRepository = new AuthNutrtionnistRepository();
    }

    /**
     * Nutritionist Register
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterNutritionist $request)
    {
        $nutritionist = $this->authNutrtionistRepository->register($request);
        $token = JWTAuth::fromUser($nutritionist);

        return response()->json(
            [
                'success' => true,
                'token' => $token,
            ],
            200
        );
    }

    /**
     * Login Nutritionist
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'invalid_email_or_password',
                ],
                401
            );
        }


        return response()->json(
            [
                'success' => true,
                'token' => $token,
            ],
            200
        );
    }
}
