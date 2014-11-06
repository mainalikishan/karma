<?php

Route::group(['prefix' => 'api/v1'], function () {
    // Individual User
    Route::post('induser/login', 'IndUserRegisterController@login');
    Route::post('induser/updateProfile', 'IndUserUpdateProfileController@updateProfile');
    Route::post('induser/setting/updatePreference', 'IndUserSettingController@updatePreference');
    Route::post('induser/setting/updateAppSetting', 'IndUserSettingController@updateAppSetting');
    Route::post('induser/setting/updateAccountStatus', 'IndUserSettingController@updateAccountStatus');
    Route::post('induser/setting/updatePrivacy', 'IndUserSettingController@updatePrivacy');
    Route::post('induser/profile/updateBasic', 'IndProfileController@updateBasic');
    Route::post('induser/profile/updateWhatIDo', 'IndProfileController@updateWhatIDo');
    Route::post('induser/profile/updateExperience', 'IndProfileController@updateExperience');
    Route::post('induser/profile/updateEducation', 'IndProfileController@updateEducation');
    Route::post('induser/profile/report', 'IndProfileController@report');
    Route::post('induser/profile/block', 'IndProfileController@blockUser');
    Route::post('induser/profile/unBlock', 'IndProfileController@unBlockUser');

    // Corporate User

    Route::post('copuser/login', 'CopUserLoginController@login');

    Route::post('copuser/register', 'CopUserRegisterController@register');
    Route::post('copuser/accountActivation', 'CopUserRegisterController@accountActivation');

    Route::post('copuser/profile', 'CopProfileController@view');
    Route::post('copuser/profile/updateProfile', 'CopProfileController@updateProfile');
    Route::post('copuser/profile/forgotPasswordCodeRequest', 'CopProfileController@codeRequest');
    Route::post('copuser/profile/forgotPasswordCodeVerify', 'CopProfileController@codeVerify');
    Route::post('copuser/profile/report', 'CopProfileController@report');
    Route::post('copuser/profile/block', 'CopProfileController@blockUser');
    Route::post('copuser/profile/unBlock', 'CopProfileController@unBlockUser');

    Route::post('copuser/setting/updateAppSetting', 'CopUserSettingController@updateAppSetting');
    Route::post('copuser/setting/updatePreference', 'CopUserSettingController@updatePreference');
    Route::post('copuser/setting/updateAccountStatus', 'CopUserSettingController@updateAccountStatus');
    Route::post('copuser/setting/updatePassword', 'CopUserSettingController@updatePassword');

    // Jobs
    Route::post('jobs/store', 'JobController@store');
    Route::post('jobs/update', 'JobController@update');
    Route::post('jobs/selectJobCache', 'JobController@selectJobCache');
    Route::post('jobs/destroy', 'JobController@destroy');

    // Jobs Application
    Route::post('jobs/Application', 'JobApplicationController@apply');

    //Notification
    Route::post('copuser/notification', 'CopNotificationController@updateStatus');
    Route::post('induser/notification', 'IndNotificationController@updateStatus');
});
