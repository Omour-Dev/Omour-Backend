<?php

Route::group(['prefix' => 'user','middleware' => 'auth:api'], function () {

    Route::get('profile'          , 'UserController@profile')->name('api.users.profile');
    Route::put('profile'          , 'UserController@updateProfile')->name('api.users.profile');
    Route::put('change-password'  , 'UserController@changePassword')->name('api.users.change.password');

    Route::get('addresses'               , 'UserController@addresses')->name('api.users.addresses');
    Route::post('add-address'            , 'UserController@addAddress')->name('api.users.add.address');
    Route::post('update-address/{id}'     , 'UserController@updateAddress')->name('api.users.update.address');
    Route::post('delete-address/{id}'    , 'UserController@deleteAddress')->name('api.users.delete.address');

});
