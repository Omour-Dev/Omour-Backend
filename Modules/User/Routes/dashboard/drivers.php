<?php

Route::group(['prefix' => 'drivers'], function () {

  	Route::get('/' ,'DriverController@index')
  	->name('dashboard.drivers.index')
    ->middleware(['permission:show_drivers']);

  	Route::get('datatable'	,'DriverController@datatable')
  	->name('dashboard.drivers.datatable')
  	->middleware(['permission:show_drivers']);

  	Route::get('create'		,'DriverController@create')
  	->name('dashboard.drivers.create')
    ->middleware(['permission:add_drivers']);

  	Route::post('/'			,'DriverController@store')
  	->name('dashboard.drivers.store')
    ->middleware(['permission:add_drivers']);

  	Route::get('{id}/edit'	,'DriverController@edit')
  	->name('dashboard.drivers.edit')
    ->middleware(['permission:edit_drivers']);

  	Route::put('{id}'		,'DriverController@update')
  	->name('dashboard.drivers.update')
    ->middleware(['permission:edit_drivers']);

  	Route::delete('{id}'	,'DriverController@destroy')
  	->name('dashboard.drivers.destroy')
    ->middleware(['permission:delete_drivers']);

  	Route::get('deletes'	,'DriverController@deletes')
  	->name('dashboard.drivers.deletes')
    ->middleware(['permission:delete_drivers']);

  	Route::get('{id}','DriverController@show')
  	->name('dashboard.drivers.show')
    ->middleware(['permission:show_drivers']);

});
