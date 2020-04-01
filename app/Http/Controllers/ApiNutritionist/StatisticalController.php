<?php

namespace App\Http\Controllers\ApiNutritionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    /**
     * Display the number of ingredients
     *
     */
    public function countIngredients()
    {
        $nutritionist = auth()->user();
        $countOfIngredient = $nutritionist->ingredients()->count();
        return response()->json(['countOfIngredient' => $countOfIngredient], 200);
    }

}
