<?php

/*
|--------------------------------------------------------------------------
| API Nutritionist Routes
|--------------------------------------------------------------------------

*/
Route::prefix('nutritionist')->group(
    function () {
        Route::post('register', 'ApiNutritionnist\NutritionistController@register');
        Route::post('login', 'ApiNutritionnist\NutritionistController@login');
        Route::middleware('auth:api')->group(function () {
                Route::get('/', 'ApiNutritionnist\NutritionistController@index');
                Route::put('/', 'ApiNutritionnist\NutritionistController@update');

                Route::prefix('patients')->group(function () {
                        Route::post('/', 'ApiNutritionnist\PatientController@store');
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
                        Route::post('/', 'ApiNutritionnist\IngredientController@store');
                        Route::delete('/{id}', 'ApiNutritionnist\IngredientController@destroy');
                        Route::get('/{id}', 'ApiNutritionnist\IngredientController@show');
                        Route::get('/', 'ApiNutritionnist\IngredientController@index');
                        Route::put('/{id}', 'ApiNutritionnist\IngredientController@update');
                });


                Route::prefix('mealStore')->group(function () {
                        Route::get('/', 'ApiNutritionnist\MealStoreController@index');
                        Route::get('/ages', 'ApiNutritionnist\MealStoreController@showByAge');
                        Route::post('/', 'ApiNutritionnist\MealStoreController@store');
                        Route::get('/{idStoreMenu}', 'ApiNutritionnist\MealStoreController@show');
                        Route::put('/{idStoreMenu}', 'ApiNutritionnist\MealStoreController@update');
                        Route::delete('/{idStoreMenu}', 'ApiNutritionnist\MealStoreController@destroy');
                        Route::prefix('{idStoreMenu}/ingredients')->group(function () {
                                Route::post('/', 'ApiNutritionnist\MealStoreController@addIngredient');
                                Route::delete(
                                    '{idIngredient}',
                                    'ApiNutritionnist\MealStoreController@deleteIngredient'
                                );
                                Route::put('{idIngredient}', 'ApiNutritionnist\MealStoreController@updateAmountPivotIngredient');
                        });
                });
        });
    }
);
