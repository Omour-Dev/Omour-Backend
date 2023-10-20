<?php

Route::group(['prefix' => 'cart' ] , function () {
    Route::get('/'                 , 'CartController@index')->name('api.cart.index');
    Route::post('add'              , 'CartController@add')->name('api.cart.add');
    Route::post('remove/{id}'      , 'CartController@remove')->name('api.cart.remove');
    Route::post('clear'            , 'CartController@clear')->name('api.cart.clear');
});
