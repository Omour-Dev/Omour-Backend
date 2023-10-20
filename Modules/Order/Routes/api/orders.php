<?php

Route::group(['prefix' => 'orders' ] , function () {
    Route::post('add'       , 'OrderController@add')->name('api.orders.add');
    Route::post('rate'      , 'OrderController@rate')->name('api.orders.rate');
    Route::get('success'    , 'OrderController@success')->name('api.orders.success');
    Route::get('failed'     , 'OrderController@failed')->name('api.orders.failed');
    Route::post('webhook'   , 'OrderController@webhook')->name('api.orders.webhook');
    Route::get('statuses'       , 'OrderController@statuses')->name('api.orders.statuses');
});

Route::group(['prefix' => 'orders' ,'middleware' => 'auth:api'], function () {

    Route::get('/'              , 'OrderController@list')->name('api.orders.list');
    Route::get('driver'         , 'OrderController@driverOrders')->name('api.orders.driver');
    Route::post('driver/update' , 'OrderController@driverUpdateOrders')->name('api.orders.update.driver');

});
