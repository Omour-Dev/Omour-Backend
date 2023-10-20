<?php

Route::group(['prefix' => 'vendors'], function () {

  	Route::get('/' ,'VendorController@index')
  	->name('dashboard.vendors.index')
    ->middleware(['permission:show_vendors']);

  	Route::get('datatable'	,'VendorController@datatable')
  	->name('dashboard.vendors.datatable')
  	->middleware(['permission:show_vendors']);

  	Route::get('create'		,'VendorController@create')
  	->name('dashboard.vendors.create')
    ->middleware(['permission:add_vendors']);

  	Route::post('/'			,'VendorController@store')
  	->name('dashboard.vendors.store')
    ->middleware(['permission:add_vendors']);

  	Route::get('{id}/edit'	,'VendorController@edit')
  	->name('dashboard.vendors.edit')
    ->middleware(['permission:edit_vendors']);

  	Route::put('{id}'		,'VendorController@update')
  	->name('dashboard.vendors.update')
    ->middleware(['permission:edit_vendors']);

  	Route::delete('{id}'	,'VendorController@destroy')
  	->name('dashboard.vendors.destroy')
    ->middleware(['permission:delete_vendors']);

  	Route::get('deletes'	,'VendorController@deletes')
  	->name('dashboard.vendors.deletes')
    ->middleware(['permission:delete_vendors']);

  	Route::get('{id}','VendorController@show')
  	->name('dashboard.vendors.show')
    ->middleware(['permission:show_vendors']);

});
