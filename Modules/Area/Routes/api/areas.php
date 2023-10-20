<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'areas'], function () {
    Route::get('cities', 'AreaController@cities')->name('api.areas.cities');
});
