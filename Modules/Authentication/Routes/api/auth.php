<?php

Route::group(['prefix' => 'auth'], function () {

    Route::post('login'             , 'UserApp\LoginController@postLogin')->name('api.auth.login');

    Route::post('register'          , 'UserApp\RegisterController@register')->name('api.auth.register');

    Route::post('forget-password'   , 'UserApp\ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/','middleware' => 'auth:api'], function () {

        Route::post('logout', 'UserApp\LoginController@logout')->name('api.auth.logout');

    });

});
