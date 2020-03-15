<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\NutritionistCreateRequest;
use App\Http\Requests\NutritionistUpdateRequest;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\JsonResponse;
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
        return response()->json(['nutritionist' => auth()->user(),], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NutritionistUpdateRequest $request
     * @return JsonResponse
     */
    public function update(NutritionistUpdateRequest $request)
    {
        $nutritionistRepository = new NutritionistRepository(auth()->user());
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $password = $request->input('password');
        $picture = $request->input('picture');
        $nutritionist = $nutritionistRepository->updateNutritionist($email, $firstName, $lastName, $password, $picture);
        return response()->json(['nutritionist' => $nutritionist,], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy()
    {
        $nutritionistRepository = new NutritionistRepository(auth()->user());
        $nutritionistRepository->deleteNutritionist();
        return response()->json(['success' => true,], 200);
    }

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
        $nutritionist = NutritionistRepository::register($email, $firstName, $lastName, $password);
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
        return response()->json(['token' => $token,], 200);
    }
}
