<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Nutritionist;
use App\Repositories\NutritionistRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendNewPassword(Request $request)
    {
        $nutritionist = Nutritionist::where('email', $request->email)->first();
        if ($nutritionist) {
            $nutritionistRepository = new NutritionistRepository($nutritionist);
            $password = Str::random(8);
            $nutritionist = $nutritionistRepository->updateNutritionist(
                $nutritionist->email,
                $nutritionist->firstName,
                $nutritionist->lastName,
                $password
            );
            Mail::to($request->email)->send(new ForgotPassword($password));
            return response()->json(['data' =>$nutritionist ], 200);
        } else {
            return response()->json(['data' =>  __('messages.emailFailed')], 200);
        }
    }
}
