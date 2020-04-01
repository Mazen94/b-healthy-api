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
    /**
     * Display the number of menus
     *
     */
    public function countMenus()
    {
        $nutritionist = auth()->user();
        $countOfMenus = $nutritionist->mealStore()->count();
        return response()->json(['countOfMenus' => $countOfMenus], 200);
    }

}
