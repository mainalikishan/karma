<?php

Route::group(['prefix' => 'api/v1'], function(){
    // Individual User routes
    Route::post('induser/login', 'IndUserRegisterController@login');
    Route::post('induser/updateProfile', 'IndUserUpdateProfileController@updateProfile');
    // Corporate User routes
    Route::post('copuser/register', 'CopUserRegisterController@register');
    Route::post('copuser/login', 'CopUserLoginController@login');
    Route::post('copuser/updateProfile', 'CopUserUpdateProfileController@updateProfile');
    Route::post('copuser/changePassword', 'CopUserChangePasswordController@changePassword');
    Route::post('copuser/accountActivation', 'CopUserActivationController@accountActivation');
    Route::post('copuser/forgotPasswordCodeRequest', 'CopUserForgotPasswordController@codeRequest');
    Route::post('copuser/forgotPasswordCodeVerify', 'CopUserForgotPasswordController@codeVerify');
    //Jobs routs
    Route::post('jobs/store', 'JobController@store');
    Route::post('jobs/update', 'JobController@update');
    Route::post('jobs/selectJobCache', 'JobController@selectJobCache');
    Route::post('jobs/destroy','JobController@destroy');
    //Jobs Application routs
    Route::post('jobs/Application', 'JobApplicationController@apply');
});
