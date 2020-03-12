<?php

/*
|--------------------------------------------------------------------------
| API Nutritionist Routes
|--------------------------------------------------------------------------

*/
Route::prefix('nutritionist')->group(
    function () {
        Route::post('register', 'ApiNutritionnist\NutritionistController@register')->name('registerNutritionist');
        Route::post('login', 'ApiNutritionnist\NutritionistController@login');
        Route::middleware('auth:api')->group(function () {
                Route::get('/', 'ApiNutritionnist\NutritionistController@index');
                Route::put('/', 'ApiNutritionnist\NutritionistController@update')->name('updateNutritionist');

                Route::prefix('patients')->group(function () {
                        Route::post('/', 'ApiNutritionnist\PatientController@store')->name('registerPatient');
                        Route::get('/', 'ApiNutritionnist\PatientController@index');


                        Route::prefix('{idPatient}')->group(function () {
                                Route::delete('/', 'ApiNutritionnist\PatientController@destroy');
                                Route::get('/', 'ApiNutritionnist\PatientController@show');


                                Route::prefix('visits')->group(function () {
                                        Route::get('/', 'ApiNutritionnist\VisitController@index');
                                        Route::post('/', 'ApiNutritionnist\VisitController@store');
                                        Route::get('/{idVisit}', 'ApiNutritionnist\VisitController@show');
                                        Route::put('/{idVisit}', 'ApiNutritionnist\VisitController@update');
                                        Route::delete('/{idVisit}', 'ApiNutritionnist\VisitController@destroy');
                                    });


                                Route::prefix('recommendations')->group(function () {
                                        Route::get('/', 'ApiNutritionnist\RecommendationController@index');
                                        Route::post('/', 'ApiNutritionnist\RecommendationController@store');
                                        Route::get(
                                            '/{idRecommendation}',
                                            'ApiNutritionnist\RecommendationController@show'
                                        );
                                        Route::put(
                                            '/{idRecommendation}',
                                            'ApiNutritionnist\RecommendationController@update'
                                        );
                                        Route::delete(
                                            '/{idRecommendation}',
                                            'ApiNutritionnist\RecommendationController@destroy'
                                        );
                                        Route::prefix('{idRecommendation}/menus')->group(function () {
                                                Route::post(
                                                    '/',
                                                    'ApiNutritionnist\RecommendationController@addMenuToRecommendation'
                                                );
                                                Route::delete(
                                                    '/{idMenu}',
                                                    'ApiNutritionnist\RecommendationController@destroyMenu'
                                                );
                                        });
                                });
                        });
                });


                Route::prefix('ingredients')->group(function () {
                        Route::post('/', 'ApiNutritionnist\IngredientConrtoller@store');
                        Route::delete('/{id}', 'ApiNutritionnist\IngredientConrtoller@destroy');
                        Route::get('/{id}', 'ApiNutritionnist\IngredientConrtoller@show');
                        Route::get('/', 'ApiNutritionnist\IngredientConrtoller@index');
                        Route::put('/{id}', 'ApiNutritionnist\IngredientConrtoller@update');
                });


                Route::prefix('storemenus')->group(function () {
                        Route::get('/', 'ApiNutritionnist\StoreMenuController@index');
                        Route::get('/ages', 'ApiNutritionnist\StoreMenuController@showByAge');
                        Route::post('/', 'ApiNutritionnist\StoreMenuController@store');
                        Route::get('/{idStoreMenu}', 'ApiNutritionnist\StoreMenuController@show');
                        Route::put('/{idStoreMenu}', 'ApiNutritionnist\StoreMenuController@update');
                        Route::delete('/{idStoreMenu}', 'ApiNutritionnist\StoreMenuController@destroy');
                        Route::prefix('{idStoreMenu}/ingredients')->group(function () {
                                Route::post('/', 'ApiNutritionnist\StoreMenuController@addIngredient');
                                Route::delete(
                                    '{idIngredient}',
                                    'ApiNutritionnist\StoreMenuController@deleteIngredient'
                                );
                                Route::put('{idIngredient}', 'ApiNutritionnist\StoreMenuController@updateAmountPivotIngredient');
                        });
                });
        });
    }
);
