<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use App\Nutritionist;
use App\Patient;
use Illuminate\Http\Request;

class StatisticalsController extends Controller
{
    /**
     * Display the number of ingredients
     *
     */
    public function count()
    {
        $nutritionistCount = Nutritionist::count();
        $waitingCount = Nutritionist::where("status",0)->count();
        $patients= Patient::count();
        $data['nutritionists' ]  = $nutritionistCount;
        $data['waitingNutritionists'] =$waitingCount;
        $data['patients'] =$patients;
        return response()->json(['data' => $data], 200);
    }
}
