<?php

/*
|--------------------------------------------------------------------------
| API Nutritionist Routes
|--------------------------------------------------------------------------

*/
Route::prefix('nutritionist')->group(
    function () {
        Route::post('register', 'ApiNutritionist\NutritionistController@register');
        Route::post('login', 'ApiNutritionist\NutritionistController@login');
        Route::middleware('auth:api')->group(function () {
                Route::get('/', 'ApiNutritionist\NutritionistController@index');
                Route::put('/', 'ApiNutritionist\NutritionistController@update');

                Route::prefix('patients')->group(function () {
                        Route::post('/', 'ApiNutritionist\PatientController@store');
                        Route::get('/', 'ApiNutritionist\PatientController@index');


                        Route::prefix('{idPatient}')->group(function () {
                                Route::delete('/', 'ApiNutritionist\PatientController@destroy');
                                Route::get('/', 'ApiNutritionist\PatientController@show');


                                Route::prefix('visits')->group(function () {
                                        Route::get('/', 'ApiNutritionist\VisitController@index');
                                        Route::post('/', 'ApiNutritionist\VisitController@store');
                                        Route::get('/{idVisit}', 'ApiNutritionist\VisitController@show');
                                        Route::put('/{idVisit}', 'ApiNutritionist\VisitController@update');
                                        Route::delete('/{idVisit}', 'ApiNutritionist\VisitController@destroy');
                                    });


                                Route::prefix('recommendations')->group(function () {
                                        Route::get('/', 'ApiNutritionist\RecommendationController@index');
                                        Route::post('/', 'ApiNutritionist\RecommendationController@store');
                                        Route::get(
                                            '/{idRecommendation}',
                                            'ApiNutritionist\RecommendationController@show'
                                        );
                                        Route::put(
                                            '/{idRecommendation}',
                                            'ApiNutritionist\RecommendationController@update'
                                        );
                                        Route::delete(
                                            '/{idRecommendation}',
                                            'ApiNutritionist\RecommendationController@destroy'
                                        );
                                        Route::prefix('{idRecommendation}/menus')->group(function () {
                                                Route::post(
                                                    '/',
                                                    'ApiNutritionist\RecommendationController@addMenuToRecommendation'
                                                );
                                                Route::delete(
                                                    '/{idMenu}',
                                                    'ApiNutritionist\RecommendationController@destroyMenu'
                                                );
                                        });
                                });
                        });
                });


                Route::prefix('ingredients')->group(function () {
                        Route::post('/', 'ApiNutritionist\IngredientController@store');
                        Route::delete('/{id}', 'ApiNutritionist\IngredientController@destroy');
                        Route::get('/{id}', 'ApiNutritionist\IngredientController@show');
                        Route::get('/', 'ApiNutritionist\IngredientController@index');
                        Route::put('/{id}', 'ApiNutritionist\IngredientController@update');
                });


                Route::prefix('mealStore')->group(function () {
                        Route::get('/', 'ApiNutritionist\MealStoreController@index');
                        Route::get('/ages', 'ApiNutritionist\MealStoreController@showByAge');
                        Route::post('/', 'ApiNutritionist\MealStoreController@store');
                        Route::get('/{idStoreMenu}', 'ApiNutritionist\MealStoreController@show');
                        Route::put('/{idStoreMenu}', 'ApiNutritionist\MealStoreController@update');
                        Route::delete('/{idStoreMenu}', 'ApiNutritionist\MealStoreController@destroy');
                        Route::prefix('{idStoreMenu}/ingredients')->group(function () {
                                Route::post('/', 'ApiNutritionist\MealStoreController@addIngredient');
                                Route::delete(
                                    '{idIngredient}',
                                    'ApiNutritionist\MealStoreController@deleteIngredient'
                                );
                                Route::put('{idIngredient}', 'ApiNutritionist\MealStoreController@updateAmountPivotIngredient');
                        });
                });
        });
    }
);
