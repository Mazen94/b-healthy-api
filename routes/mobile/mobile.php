<?php

Route::prefix('patient')->group(
    function () {
        Route::post('login', 'ApiPatient\AuthPatientController@login');
        Route::middleware('auth:api-patient')->group(
            function () {
                Route::get('/', 'ApiPatient\PatientController@index');
                Route::put('/', 'ApiPatient\PatientController@update');

                Route::prefix('recommendation')->group(
                    function () {
                        Route::get('/', 'ApiPatient\RecommendationController@index');
                        Route::get('/menus', 'ApiPatient\RecommendationController@indexMenus');
                    }
                );


                Route::prefix('notifications')->group(
                    function () {
                        Route::get('/', 'ApiPatient\NotificationController@index');
                        Route::post('/', 'ApiPatient\NotificationController@store');
                        Route::delete('/{id_notification}', 'ApiPatient\NotificationController@destroy');
                        Route::get('/{id_notification}', 'ApiPatient\NotificationController@show');
                    }
                );
            }
        );
    }
);
