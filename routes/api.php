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
Route::prefix('nutritionist')->group(
    function () {
        Route::post('register', 'ApiNutritionnist\AuthNutrtionnistConrtoller@register')->name('Register Nutritionnist');
        Route::post('login', 'ApiNutritionnist\AuthNutrtionnistConrtoller@login')->name('Login Nutritionnist');
        Route::middleware('auth:api')->group(
            function () {
                Route::post('patients/', 'ApiNutritionnist\PatientController@store')->name('Store Patient');
                Route::delete('patient/{id}', 'ApiNutritionnist\PatientController@destroy')->name('Delete Patient');
                Route::get('patient/{id}', 'ApiNutritionnist\PatientController@show')->name(
                    'Recovery only one Patient'
                );
                Route::get('patients/', 'ApiNutritionnist\PatientController@index')->name('Recovery all patients');


                Route::post('ingredients/', 'ApiNutritionnist\IngredientConrtoller@store')->name('Store ingredient');
                Route::delete('ingredient/{id}', 'ApiNutritionnist\IngredientConrtoller@destroy')->name(
                    'Delete ingredient'
                );
                Route::get('ingredient/{id}', 'ApiNutritionnist\IngredientConrtoller@show')->name(
                    'Recovery only one ingredient'
                );
                Route::get('ingredients/', 'ApiNutritionnist\IngredientConrtoller@index')->name('Recovery ingredients');
                Route::put('ingredient/{id}', 'ApiNutritionnist\IngredientConrtoller@update')->name(
                    'Update ingredient'
                );


                Route::get('patient/{id_patient}/visits', 'ApiNutritionnist\VisitController@index')->name(
                    'Recovery visits related to patient'
                );
                Route::post('patient/{id_patient}/visits', 'ApiNutritionnist\VisitController@store')->name(
                    'Store visit related to patient'
                );
                Route::get('patient/{id_patient}/visit/{id_visit}', 'ApiNutritionnist\VisitController@show')->name(
                    'Recovery only one visit related to patient'
                );
                Route::put('patient/{id_patient}/visit/{id_visit}', 'ApiNutritionnist\VisitController@update')->name(
                    'update visits related to patient'
                );
                Route::delete(
                    'patient/{id_patient}/visit/{id_visit}',
                    'ApiNutritionnist\VisitController@destroy'
                )->name('delete visit related to patient');

                Route::get('storemenus/', 'ApiNutritionnist\StoreMenuController@index')->name('Recovery StoreMenus');
                Route::post('storemenus', 'ApiNutritionnist\StoreMenuController@store')->name('Store a StoreMenu');
                Route::get('storemenu/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@show')->name(
                    'Recovery only one Storemenu'
                );
                Route::put('storemenu/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@update')->name(
                    'update only one Storemenu'
                );
                Route::delete('storemenu/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@destroy')->name(
                    'delete  Storemenu'
                );

                Route::post(
                    'storemenu/{id_storemenus}/ingredient/',
                    'ApiNutritionnist\StoreMenuController@addIngredient'
                )->name(
                    'Add ingredient to a storeMenu'
                );
                Route::delete(
                    'storemenu/{id_storemenus}/ingredient/{id_ingredient}',
                    'ApiNutritionnist\StoreMenuController@deleteIngredient'
                )->name(
                    'Add ingredient to a storeMenu'
                );
                Route::put(
                    'storemenu/{id_storemenus}/ingredient/{id_ingredient}',
                    'ApiNutritionnist\StoreMenuController@updateIngredient'
                )->name(
                    'update amount ingredient related a storeMenu'
                );


                Route::get(
                    'patient/{patient_id}/recommendations',
                    'ApiNutritionnist\RecommandationController@index'
                )->name(
                    'Recovery all recommendations '
                );
                Route::post(
                    'patient/{patient_id}/recommendation',
                    'ApiNutritionnist\RecommandationController@store'
                )->name(
                    'Store visit recommendations'
                );
                Route::get(
                    'patient/{patient_id}/recommendation/{id_recommendation}',
                    'ApiNutritionnist\RecommandationController@show'
                )->name(
                    'Recovery only one recommendations'
                );
                Route::put(
                    'patient/{patient_id}/recommendation/{id_recommendation}',
                    'ApiNutritionnist\RecommandationController@update'
                )->name(
                    'update recommendation'
                );
                Route::delete(
                    'patient/{patient_id}/recommendation/{id_recommendation}',
                    'ApiNutritionnist\VisitController@destroy'
                )->name('delete recommendation ');
            }
        );
    }
);

/*
|--------------------------------------------------------------------------
| API Patient Routes
|--------------------------------------------------------------------------

*/
Route::prefix('patient')->group(
    function () {
    }
);
