<?php

Route::group(['prefix' => 'api/v1'], function(){
    // Individual User routes
    Route::get('induser/login', 'IndUserRegisterController@login');

    // Corporate User routes
});
