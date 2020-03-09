<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterNutritionist;
use App\Repositories\NutritionnistRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;

class NutritionnistController extends Controller
{

    /**
     * Display the specified resource.
     *
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            [
                'success' => true,
                'nutritionist' => auth()->user(),
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $nutritionistRepository = new NutritionnistRepository();
        $nutritionist = $nutritionistRepository->updateNutritionist(
            $request['email'],
            $request['firstName'],
            $request['lastName'],
            $request['password'],
            $request['picture']
        );
        return response()->json(
            [
                'success' => true,
                'nutritionist' => $nutritionist,
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy()
    {
        $nutritionistRepository = new NutritionnistRepository();
        $nutritionistRepository->deleteNutritionist();
        return response()->json(
            [
                'success' => true,
            ],
            200
        );
    }

    /**
     * Nutritionist Register
     * @param RegisterNutritionist $request
     * @return JsonResponse
     */
    public function register(RegisterNutritionist $request)
    {
        $nutritionistRepository = new NutritionnistRepository();
        $nutritionist = $nutritionistRepository->register(
            $request['email'],
            $request['firstName'],
            $request['lastName'],
            $request['password']
        );
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
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
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
