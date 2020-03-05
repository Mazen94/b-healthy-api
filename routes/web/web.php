<?php

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
                Route::get('/', 'ApiNutritionnist\NutritionnistController@index');
                Route::put('/', 'ApiNutritionnist\NutritionnistController@update');

                Route::prefix('patients')->group(
                    function () {
                        Route::post('/', 'ApiNutritionnist\PatientController@store')->name('Store Patient');
                        Route::get('/', 'ApiNutritionnist\PatientController@index')->name('Recovery all patients');
                        Route::prefix('{id_patient}')->group(
                            function () {
                                Route::delete('/', 'ApiNutritionnist\PatientController@destroy')->name(
                                    'Delete Patient'
                                );
                                Route::get('/', 'ApiNutritionnist\PatientController@show')->name(
                                    'Recovery only one Patient'
                                );
                                Route::prefix('visits')->group(
                                    function () {
                                        Route::get('/', 'ApiNutritionnist\VisitController@index')->name(
                                            'Recovery visits related to patient'
                                        );
                                        Route::post('/', 'ApiNutritionnist\VisitController@store')->name(
                                            'Store visit related to patient'
                                        );
                                        Route::get('/{id_visit}', 'ApiNutritionnist\VisitController@show')->name(
                                            'Recovery only one visit related to patient'
                                        );
                                        Route::put('=/{id_visit}', 'ApiNutritionnist\VisitController@update')->name(
                                            'update visits related to patient'
                                        );
                                        Route::delete(
                                            '/{id_visit}',
                                            'ApiNutritionnist\VisitController@destroy'
                                        )->name('delete visit related to patient');
                                    }
                                );
                                Route::prefix('recommendations')->group(
                                    function () {
                                        Route::get(
                                            '/',
                                            'ApiNutritionnist\RecommandationController@index'
                                        )->name(
                                            'Recovery all recommendations '
                                        );
                                        Route::post(
                                            '/',
                                            'ApiNutritionnist\RecommandationController@store'
                                        )->name(
                                            'Store  recommendations'
                                        );
                                        Route::get(
                                            '/{id_recommendation}',
                                            'ApiNutritionnist\RecommandationController@show'
                                        )->name(
                                            'Recovery only one recommendations'
                                        );
                                        Route::put(
                                            '/{id_recommendation}',
                                            'ApiNutritionnist\RecommandationController@update'
                                        )->name(
                                            'update recommendation'
                                        );
                                        Route::delete(
                                            '/{id_recommendation}',
                                            'ApiNutritionnist\RecommandationController@destroy'
                                        )->name('delete recommendation ');
                                        Route::prefix('{id_recommendation}/menus')->group(
                                            function () {
                                                Route::post(
                                                    '/',
                                                    'ApiNutritionnist\RecommandationController@storeMenu'
                                                )->name(
                                                    'Store menu to recommendations'
                                                );
                                                Route::delete(
                                                    '/{id_menu}',
                                                    'ApiNutritionnist\RecommandationController@destroyMenu'
                                                )->name(
                                                    'delete  menu to recommendations'
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
                        Route::post('/', 'ApiNutritionnist\IngredientConrtoller@store')->name('Store ingredient');
                        Route::delete('/{id}', 'ApiNutritionnist\IngredientConrtoller@destroy')->name(
                            'Delete ingredient'
                        );
                        Route::get('/{id}', 'ApiNutritionnist\IngredientConrtoller@show')->name(
                            'Recovery only one ingredient'
                        );
                        Route::get('/', 'ApiNutritionnist\IngredientConrtoller@index')->name('Recovery ingredients');
                        Route::put('/{id}', 'ApiNutritionnist\IngredientConrtoller@update')->name(
                            'Update ingredient'
                        );
                    }
                );
                Route::prefix('storemenus')->group(
                    function () {
                        Route::get('/', 'ApiNutritionnist\StoreMenuController@index')->name('Recovery StoreMenus');
                        Route::post('/', 'ApiNutritionnist\StoreMenuController@store')->name('Store a StoreMenu');
                        Route::get('/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@show')->name(
                            'Recovery only one Storemenu'
                        );
                        Route::put('/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@update')->name(
                            'update only one Storemenu'
                        );
                        Route::delete('/{id_storemenus}', 'ApiNutritionnist\StoreMenuController@destroy')->name(
                            'delete  Storemenu'
                        );
                        Route::prefix('{id_storemenus}/ingredients')->group(
                            function () {
                                Route::post(
                                    '/',
                                    'ApiNutritionnist\StoreMenuController@addIngredient'
                                )->name(
                                    'Add ingredient to a storeMenu'
                                );
                                Route::delete(
                                    '{id_ingredient}',
                                    'ApiNutritionnist\StoreMenuController@deleteIngredient'
                                )->name(
                                    'Add ingredient to a storeMenu'
                                );
                                Route::put(
                                    '{id_ingredient}',
                                    'ApiNutritionnist\StoreMenuController@updateIngredient'
                                )->name(
                                    'update amount ingredient related a storeMenu'
                                );
                            }
                        );
                    }
                );
            }

        );
    }
);
