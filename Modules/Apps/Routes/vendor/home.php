<?php

Route::group(['prefix' => '/' ,'middleware' => [
    'vendor.auth',
    'vendor.redirect'
]], function() {

    Route::get('/'  , 'VendorController@index')->name('vendor.home');

});
