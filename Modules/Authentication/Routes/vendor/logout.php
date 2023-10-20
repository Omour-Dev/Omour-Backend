<?php

Route::group(['prefix' => 'logout','middleware' => 'auth'], function () {

    // Logout
    Route::any('/', 'LoginController@logout')
    ->name('vendor.logout');

});
