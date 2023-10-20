<?php

Route::group(['prefix' => 'vendors'], function () {

    Route::get('/'      , 'VendorController@vendors')->name('api.vendors.index');
    Route::get('{id}'   , 'VendorController@vendor')->name('api.vendors.show');

});
