<?php

Route::group(['prefix' => 'logout','middleware' => 'dashboard.auth'], function () {

    // Logout
    Route::any('/', 'LoginController@logout')
    ->name('dashboard.logout');

});
