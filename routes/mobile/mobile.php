<?php

Route::prefix('patient')->group(
    function () {
        Route::post('login', 'ApiPatient\AuthPatientController@login');
        Route::middleware('auth:api-patient')->group(
            function () {
                Route::get('/', 'ApiPatient\PatientController@index');
                Route::put('/', 'ApiPatient\PatientController@update');
            }
        );
    }
);
