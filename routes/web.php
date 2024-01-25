<?php


Route::get('install/app'                , 'InstallController@installation')->name('installation');
Route::get('install/configuration'      , 'InstallController@configurations')->name('show.configurations');
Route::post('install/configuration'     , 'InstallController@store')->name('store.configurations');
Route::post('install/db/configuration'  , 'InstallController@db')->name('store.db.configurations');
Route::post('install/app/configuration' , 'InstallController@app')->name('store.app.configurations');
Route::get('install/complete'           , 'InstallController@complete')->name('complete.installation');
Route::get('/cart/add', function () {
    return view('test');
});
