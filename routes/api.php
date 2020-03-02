<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*
|--------------------------------------------------------------------------
| API Nutritionist Routes
|--------------------------------------------------------------------------

*/
Route::prefix('nutritionist')->group(function () {
    Route::post('register','ApiNutritionnist\AuthNutrtionnistConrtoller@register');
    Route::post('login','ApiNutritionnist\AuthNutrtionnistConrtoller@login');
    Route::middleware('auth:api')->group(function(){

        Route::post('patients/','ApiNutritionnist\PatientController@store');
        Route::delete('patient/{id}','ApiNutritionnist\PatientController@destroy');
        Route::get('patient/{id}','ApiNutritionnist\PatientController@show');
        Route::get('patients/','ApiNutritionnist\PatientController@index');

        Route::post('ingredients/','ApiNutritionnist\IngredientConrtoller@store');
        Route::delete('ingredient/{id}','ApiNutritionnist\IngredientConrtoller@destroy');
        Route::get('ingredient/{id}','ApiNutritionnist\IngredientConrtoller@show');
        Route::get('ingredients/','ApiNutritionnist\IngredientConrtoller@index');
        Route::put('ingredient/{id}','ApiNutritionnist\IngredientConrtoller@update');


    });

});

/*
|--------------------------------------------------------------------------
| API Patient Routes
|--------------------------------------------------------------------------

*/
Route::prefix('patient')->group(function () {

});
