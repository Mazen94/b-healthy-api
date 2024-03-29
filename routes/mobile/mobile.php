<?php

Route::prefix('patient')->group(
    function () {
        Route::post('login', 'ApiPatient\AuthController@login');
        Route::post('forgotPassword', 'ApiPatient\ForgotPasswordController@sendNewPassword');
        Route::middleware('auth:api-patient')->group(
            function () {
                Route::get('/', 'ApiPatient\PatientController@index');
                Route::put('/', 'ApiPatient\PatientController@update');
                Route::post('/uploadImage', 'ApiPatient\PatientController@uploadImage');
                Route::put('/password', 'ApiPatient\PatientController@changePassword');
                Route::get('/nutritionist', 'ApiPatient\PatientController@getNutritionist');
                Route::prefix('recommendation')->group(
                    function () {
                        Route::get('/', 'ApiPatient\RecommendationController@getLastRecommendation');
                        Route::post('/{idRecommendation}/menus', 'ApiPatient\MenuController@store');
                    }
                );

                Route::prefix('menus')->group(
                    function () {
                        Route::get('/{idMenu}', 'ApiPatient\MenuController@show');
                        Route::get('/', 'ApiPatient\MenuController@getMenuByDate');
                        Route::delete('/{idMenu}/ingredients/{idIngredient}', 'ApiPatient\IngredientController@detachIngredientToMenu');
                        Route::put('/{idMenu}/ingredients/{idIngredient}', 'ApiPatient\IngredientController@updateAmountOfIngredient');
                    }
                );

                Route::prefix('ingredients')->group(
                    function () {
                        Route::get('', 'ApiPatient\IngredientController@index');
                        Route::post('', 'ApiPatient\IngredientController@addIngredientToMenu');
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
                Route::prefix('visits')->group(
                    function () {
                        Route::get('', 'ApiPatient\VisitController@getLastVisit');
                    }
                );
                Route::prefix('statistical')->group(
                    function () {
                        Route::get('/weight', 'ApiPatient\StatisticalController@getWeightMonth');
                        Route::get('/followUp', 'ApiPatient\StatisticalController@followUpRate');
                    }
                );
            }
        );
    }
);
