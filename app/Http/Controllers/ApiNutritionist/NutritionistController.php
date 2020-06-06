<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Http\Requests\NutritionistUpdateRequest;
use App\Http\Requests\UploadImageRequest;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use JWTAuth;
use Image;
use Config;

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
        $nutritionist = $nutritionistRepository->updateNutritionist($email, $firstName, $lastName, $password);
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

    /**
     * upload image
     * @param UploadImageRequest $request
     * @return mixed
     */
    public function uploadImage(UploadImageRequest $request)
    {
        $nutritionist = auth()->user();
        $photo = $request->file('photo');
        if ($nutritionist->photo != Config::get('constants.IMAGE_NUTRITIONIST')) {
            unlink('images/nutritionists/' . $nutritionist->photo);
        }
        $fileName = uniqid() . '-' . time() . '.' . $photo->guessExtension();
        $location = public_path(Config::get('constants.PATH_IMAGES_NUTRITIONIST') . $fileName);
        Image::make($photo)->resize(300, 300)->save($location);
        $nutritionist->photo = $fileName;
        $nutritionist->save();
        return response()->json(['data' => $fileName,], 200);
    }
}
