<?php

Route::group(['prefix' => 'vendors'], function () {

    Route::get('/'      , 'VendorController@vendors')->name('api.vendors.index');
    Route::get('{id}'   , 'VendorController@vendor')->name('api.vendors.show');
});

Route::group(['prefix' => 'vendors', 'middleware' => 'auth:api'], function () {
    Route::post('addShippingPrice' , 'VendorController@addShippingPrice')->name('api.vendors.addShippingPrice');
    Route::put('UpdateShippingPrice' , 'VendorController@UpdateShippingPrice')->name('api.vendors.UpdateShippingPrice');
});
