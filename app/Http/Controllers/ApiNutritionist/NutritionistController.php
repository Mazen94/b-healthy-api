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
    public function connectedUser()
    {
        return response()->json(['data' => auth()->user(),], 200);
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
        return response()->json(['data' => $nutritionist,], 200);
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
        return response()->json(['data' => true,], 200);
    }


}
