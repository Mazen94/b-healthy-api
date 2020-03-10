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
        Route::middleware('auth:api')->group(
            function () {
                Route::get('/', 'ApiNutritionnist\NutritionistController@index');
                Route::put('/', 'ApiNutritionnist\NutritionistController@update')->name('updateNutritionist');

                Route::prefix('patients')->group(
                    function () {
                        Route::post('/', 'ApiNutritionnist\PatientController@store')->name('registerPatient');
                        Route::get('/', 'ApiNutritionnist\PatientController@index');


                        Route::prefix('{id_patient}')->group(
                            function () {
                                Route::delete('/', 'ApiNutritionnist\PatientController@destroy');
                                Route::get('/', 'ApiNutritionnist\PatientController@show');


                                Route::prefix('visits')->group(
                                    function () {
                                        Route::get('/', 'ApiNutritionnist\VisitController@index');
                                        Route::post('/', 'ApiNutritionnist\VisitController@store');
                                        Route::get('/{id_visit}', 'ApiNutritionnist\VisitController@show');
                                        Route::put('=/{id_visit}', 'ApiNutritionnist\VisitController@update');
                                        Route::delete('/{id_visit}', 'ApiNutritionnist\VisitController@destroy');
                                    }
                                );


                                Route::prefix('recommendations')->group(
                                    function () {
                                        Route::get('/', 'ApiNutritionnist\RecommandationController@index');
                                        Route::post('/', 'ApiNutritionnist\RecommandationController@store');
                                        Route::get(
                                            '/{id_recommendation}',
                                            'ApiNutritionnist\RecommandationController@show'
                                        );
                                        Route::put(
                                            '/{id_recommendation}',
                                            'ApiNutritionnist\RecommandationController@update'
                                        );
                                        Route::delete(
                                            '/{id_recommendation}',
                                            'ApiNutritionnist\RecommandationController@destroy'
                                        );
                                        Route::prefix('{id_recommendation}/menus')->group(
                                            function () {
                                                Route::post('/', 'ApiNutritionnist\RecommandationController@storeMenu');
                                                Route::delete(
                                                    '/{id_menu}',
                                                    'ApiNutritionnist\RecommandationController@destroyMenu'
                                                );
                                            }
                                        );
                                    }
                                );
                            }
                        );
                    }
                );


                Route::prefix('ingredients')->group(
                    function () {
                        Route::post('/', 'ApiNutritionnist\IngredientConrtoller@store');
                        Route::delete('/{id}', 'ApiNutritionnist\IngredientConrtoller@destroy');
                        Route::get('/{id}', 'ApiNutritionnist\IngredientConrtoller@show');
                        Route::get('/', 'ApiNutritionnist\IngredientConrtoller@index');
                        Route::put('/{id}', 'ApiNutritionnist\IngredientConrtoller@update');
                    }
                );


                Route::prefix('storemenus')->group(
                    function () {
                        Route::get('/', 'ApiNutritionnist\StoreMenuController@index');
                        Route::get('/ages', 'ApiNutritionnist\StoreMenuController@showByAge');
                        Route::post('/', 'ApiNutritionnist\StoreMenuController@store');
                        Route::get('/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@show');
                        Route::put('/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@update');
                        Route::delete('/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@destroy');
                        Route::prefix('{id_storemenus}/ingredients')->group(
                            function () {
                                Route::post('/', 'ApiNutritionnist\StoreMenuController@addIngredient');
                                Route::delete(
                                    '{id_ingredient}',
                                    'ApiNutritionnist\StoreMenuController@deleteIngredient'
                                );
                                Route::put('{id_ingredient}', 'ApiNutritionnist\StoreMenuController@updateIngredient');
                            }
                        );
                    }
                );
            }

        );
    }
);
