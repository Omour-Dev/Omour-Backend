<?php

Route::group(['prefix' => 'products'], function () {

    Route::get('/'                , 'ProductController@products');
    Route::get('variations'       , 'ProductController@productVariation');

});
