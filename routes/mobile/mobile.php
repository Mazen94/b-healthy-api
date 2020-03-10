<?php

Route::prefix('patient')->group(
    function () {
        Route::post('login', 'ApiPatient\PatientController@login');
        Route::middleware('auth:api-patient')->group(
            function () {
                Route::get('/', 'ApiPatient\PatientController@index');
                Route::put('/', 'ApiPatient\PatientController@update')->name('updatePatient');

                Route::prefix('recommendation')->group(
                    function () {
                        Route::get('/', 'ApiPatient\RecommendationController@index');
                        Route::get('/menus', 'ApiPatient\RecommendationController@indexMenus');
                        Route::post('/{id_recommendation}/menus', 'ApiPatient\MenuController@store');
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
