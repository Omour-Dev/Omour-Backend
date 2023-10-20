<?php

Route::group(['prefix' => 'sellers'], function () {

  	Route::get('/' ,'VendorController@index')
  	->name('dashboard.sellers.index')
    ->middleware(['permission:show_vendors']);

  	Route::get('datatable'	,'VendorController@datatable')
  	->name('dashboard.sellers.datatable')
  	->middleware(['permission:show_vendors']);

  	Route::get('create'		,'VendorController@create')
  	->name('dashboard.sellers.create')
    ->middleware(['permission:add_vendors']);

  	Route::post('/'			,'VendorController@store')
  	->name('dashboard.sellers.store')
    ->middleware(['permission:add_vendors']);

  	Route::get('{id}/edit'	,'VendorController@edit')
  	->name('dashboard.sellers.edit')
    ->middleware(['permission:edit_vendors']);

  	Route::put('{id}'		,'VendorController@update')
  	->name('dashboard.sellers.update')
    ->middleware(['permission:edit_vendors']);

  	Route::delete('{id}'	,'VendorController@destroy')
  	->name('dashboard.sellers.destroy')
    ->middleware(['permission:delete_vendors']);

  	Route::get('deletes'	,'VendorController@deletes')
  	->name('dashboard.sellers.deletes')
    ->middleware(['permission:delete_vendors']);

  	Route::get('{id}','VendorController@show')
  	->name('dashboard.sellers.show')
    ->middleware(['permission:show_vendors']);

});
