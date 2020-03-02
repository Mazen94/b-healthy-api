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
        Route::delete('tasks/{id}','API\TasksController@destroy');
        Route::put('tasks/{id}','API\TasksController@update');
        Route::get('patient/{id}','ApiNutritionnist\PatientController@show');
        Route::get('patients/','ApiNutritionnist\PatientController@index');
        Route::get('logout', 'AuthPassport\AuthController@logout');

    });

});

/*
|--------------------------------------------------------------------------
| API Patient Routes
|--------------------------------------------------------------------------

*/
Route::prefix('patient')->group(function () {

});
