<?php

Route::prefix('patient')->group(
    function () {
        Route::post('login', 'ApiPatient\AuthController@login');
        Route::middleware('auth:api-patient')->group(
            function () {
                Route::get('/', 'ApiPatient\PatientController@index');
                Route::put('/', 'ApiPatient\PatientController@update');

                Route::prefix('recommendation')->group(
                    function () {
                        Route::get('/', 'ApiPatient\RecommendationController@getLastRecommendation');
                        Route::post('/{idRecommendation}/menus', 'ApiPatient\MenuController@store');
                    }
                );

                Route::prefix('menus')->group(
                    function () {
                        Route::get('/{idMenu}', 'ApiPatient\MenuController@show');
                    }
                );

                Route::prefix('ingredients')->group(
                    function () {
                        Route::get('', 'ApiPatient\IngredientController@index');
                    }
                );
                Route::prefix('notifications')->group(
                    function () {
                        Route::get('/', 'ApiPatient\NotificationController@index');
                        Route::post('/', 'ApiPatient\NotificationController@store');
                        Route::delete('/{idNotification}', 'ApiPatient\NotificationController@destroy');
                        Route::get('/{idNotification}', 'ApiPatient\NotificationController@show');
                    }
                );

                Route::prefix('activity')->group(
                    function () {
                        Route::get('/', 'ApiPatient\PhysicalActiviteController@index');
                        Route::post('/', 'ApiPatient\PhysicalActiviteController@store');
                    }
                );
            }
        );
    }
);
