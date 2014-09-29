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



});
