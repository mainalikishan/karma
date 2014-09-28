<?php

Route::group(['prefix' => 'api/v1'], function(){
    // Individual User routes
    Route::post('induser/login', 'IndUserRegisterController@login');
    // Corporate User routes
    Route::post('copuser/register', 'CopUserRegisterController@register');
    Route::post('copuser/login', 'CopUserLoginController@login');

});
