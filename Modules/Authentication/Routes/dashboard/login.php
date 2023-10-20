<?php

Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN')):

        // Show Login Form
        Route::get('/', 'LoginController@showLogin')
        ->name('dashboard.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'LoginController@postLogin')
        ->name('dashboard.login');

    endif;

});
