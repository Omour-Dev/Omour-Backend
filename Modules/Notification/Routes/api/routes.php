<?php

Route::group(['prefix' => 'notifications' ,'middleware' => 'auth:api'] , function () {

    Route::get('/'                    , 'NotificationController@list')->name('api.notifications.list');
    Route::post('read-notifications'  , 'NotificationController@readNotification')->name('api.notifications.read');
    Route::post('delete'              , 'NotificationController@delete')->name('api.notifications.delete');
    Route::post('clear-all'           , 'NotificationController@clearAll')->name('api.notifications.clear');

});
