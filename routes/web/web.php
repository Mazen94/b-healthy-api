<?php

/*
|--------------------------------------------------------------------------
| API Admin Routes
|--------------------------------------------------------------------------

*/
Route::prefix('admin')->group(
    function () {
        Route::post('login', 'ApiAdmin\AuthController@login');
        Route::post('forgotPassword', 'ApiAdmin\ForgotPasswordController@sendNewPassword');
        Route::middleware('auth:api-admin')->group(
            function () {
                Route::get('/nutritionist', 'ApiAdmin\NutritionistsController@index');
                Route::post('/nutritionist/{id}', 'ApiAdmin\NutritionistsController@activate');
                Route::delete('/nutritionist/{id}', 'ApiAdmin\NutritionistsController@destroy');
                Route::get('/stats', 'ApiAdmin\StatisticalsController@count');
            }
        );
    }
);

/*
|--------------------------------------------------------------------------
| API Nutritionist Routes
|--------------------------------------------------------------------------

*/
Route::prefix('nutritionist')->group(
    function () {
        Route::post('register', 'ApiNutritionist\AuthController@register');
        Route::post('login', 'ApiNutritionist\AuthController@login');
        Route::post('forgotPassword', 'ApiNutritionist\ForgotPasswordController@sendNewPassword');
        Route::middleware('auth:api')->group(
            function () {
                Route::get('/', 'ApiNutritionist\NutritionistController@connectedUser');
                Route::put('/', 'ApiNutritionist\NutritionistController@update');
                Route::post('/uploadImage', 'ApiNutritionist\NutritionistController@uploadImage');
                Route::post('/meeting', 'ApiNutritionist\VisitController@showMeetingHour');
                Route::get('/meetingOfDay', 'ApiNutritionist\VisitController@showMeetingOfDay');
                Route::post('/deleteMeeting', 'ApiNutritionist\VisitController@deleteMeeting');

                Route::prefix('patients')->group(
                    function () {
                        Route::post('/', 'ApiNutritionist\PatientController@store');
                        Route::get('/', 'ApiNutritionist\PatientController@index');


                        Route::prefix('{idPatient}')->group(
                            function () {
                                Route::delete('/', 'ApiNutritionist\PatientController@destroy');
                                Route::get('/', 'ApiNutritionist\PatientController@show');


                                Route::prefix('visits')->group(
                                    function () {
                                        Route::get('/', 'ApiNutritionist\VisitController@index');
                                        Route::post('/', 'ApiNutritionist\VisitController@newMeasure');

                                        Route::post('/newMeeting', 'ApiNutritionist\VisitController@newMeeting');
                                    }
                                );
                                Route::prefix('statistical')->group(
                                    function () {
                                        Route::get(
                                            '/progression',
                                            'ApiNutritionist\StatisticalController@getStatisticalOfPatient'
                                        );
                                        Route::get(
                                            '/followRate',
                                            'ApiNutritionist\StatisticalController@followUpRate'
                                        );
                                    }
                                );

                                Route::prefix('recommendations')->group(
                                    function () {
                                        Route::get('/', 'ApiNutritionist\RecommendationController@index');
                                        Route::get(
                                            '/menus',
                                            'ApiNutritionist\MenuController@getMenus'
                                        );
                                        Route::get(
                                            '/menus/{idMenu}',
                                            'ApiNutritionist\MenuController@show'
                                        );
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
                                        Route::prefix('{idRecommendation}/menus')->group(
                                            function () {
                                                Route::post(
                                                    '/',
                                                    'ApiNutritionist\MenuController@store'
                                                );
                                                Route::delete(
                                                    '/{idMenu}',
                                                    'ApiNutritionist\MenuController@destroy'
                                                );
                                            }
                                        );
                                    }
                                );
                            }
                        );
                    }
                );
                Route::prefix('statistics')->group(
                    function () {
                        Route::get('/ingredients', 'ApiNutritionist\StatisticalController@countIngredients');
                        Route::get('/menus', 'ApiNutritionist\StatisticalController@countMenus');
                        Route::get('/gender', 'ApiNutritionist\StatisticalController@genderPatient');
                        Route::get('/age', 'ApiNutritionist\StatisticalController@rangeAgePatient');
                    }
                );

                Route::prefix('ingredients')->group(
                    function () {
                        Route::post('/', 'ApiNutritionist\IngredientController@store');
                        Route::delete('/{id}', 'ApiNutritionist\IngredientController@destroy');
                        Route::get('/{id}', 'ApiNutritionist\IngredientController@show');
                        Route::get('/', 'ApiNutritionist\IngredientController@index');
                        Route::put('/{ingredient}', 'ApiNutritionist\IngredientController@update');
                    }
                );


                Route::prefix('mealStore')->group(
                    function () {
                        Route::get('/', 'ApiNutritionist\MealStoreController@index');
                        Route::get('/ages', 'ApiNutritionist\MealStoreController@showByAge');
                        Route::post('/', 'ApiNutritionist\MealStoreController@store');
                        Route::get('/{idStoreMenu}', 'ApiNutritionist\MealStoreController@show');
                        Route::put('/{idStoreMenu}', 'ApiNutritionist\MealStoreController@update');
                        Route::delete('/{idStoreMenu}', 'ApiNutritionist\MealStoreController@destroy');
                        Route::prefix('{idStoreMenu}/ingredients')->group(
                            function () {
                                Route::post('/', 'ApiNutritionist\IngredientController@addIngredientToMealStore');
                                Route::delete(
                                    '{idIngredient}',
                                    'ApiNutritionist\IngredientController@deleteIngredientMealStore'
                                );
                                Route::put(
                                    '{idIngredient}',
                                    'ApiNutritionist\IngredientController@updateAmountPivotIngredient'
                                );
                            }
                        );
                    }
                );
            }
        );
    }
);
