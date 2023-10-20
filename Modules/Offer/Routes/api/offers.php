<?php

Route::group(['prefix' => 'offers'], function () {

    Route::get('/'      , 'OfferController@offers')->name('api.offers.index');
    Route::get('{id}'   , 'OfferController@offer')->name('api.offers.show');

});
