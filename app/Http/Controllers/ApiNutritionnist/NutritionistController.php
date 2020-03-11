<?php

namespace App\Http\Controllers\ApiNutritionnist;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\NutritionistRequest;
use App\Repositories\NutritionnistRepository;
use Illuminate\Http\JsonResponse;
use Config;
use JWTAuth;

class NutritionistController extends Controller
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
     * @param NutritionistRequest $request
     * @return JsonResponse
     */
    public function update(NutritionistRequest $request)
    {
        $nutritionistRepository = new NutritionnistRepository(auth()->user());
        $nutritionist = $nutritionistRepository->updateNutritionist(
            $request->input('email'),
            $request->input('firstName'),
            $request->input('lastName'),
            $request->input('password'),
            $request->input('picture')
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
        $nutritionistRepository = new NutritionnistRepository(auth()->user());
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
     * @param NutritionistRequest $request
     * @return JsonResponse
     */
    public function register(NutritionistRequest $request)
    {
        $nutritionist = NutritionnistRepository::register(
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
                    'message' => Config::get('constants.FAILED_TO_LOGIN')
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
