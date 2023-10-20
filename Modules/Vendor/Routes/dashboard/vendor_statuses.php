<?php

Route::group(['prefix' => 'vendor-statuses'], function () {

  	Route::get('/' ,'VendorStatusController@index')
  	->name('dashboard.vendor_statuses.index')
    ->middleware(['permission:show_vendor_statuses']);

  	Route::get('datatable'	,'VendorStatusController@datatable')
  	->name('dashboard.vendor_statuses.datatable')
  	->middleware(['permission:show_vendor_statuses']);

  	Route::get('create'		,'VendorStatusController@create')
  	->name('dashboard.vendor_statuses.create')
    ->middleware(['permission:add_vendor_statuses']);

  	Route::post('/'			,'VendorStatusController@store')
  	->name('dashboard.vendor_statuses.store')
    ->middleware(['permission:add_vendor_statuses']);

  	Route::get('{id}/edit'	,'VendorStatusController@edit')
  	->name('dashboard.vendor_statuses.edit')
    ->middleware(['permission:edit_vendor_statuses']);

  	Route::put('{id}'		,'VendorStatusController@update')
  	->name('dashboard.vendor_statuses.update')
    ->middleware(['permission:edit_vendor_statuses']);

  	Route::delete('{id}'	,'VendorStatusController@destroy')
  	->name('dashboard.vendor_statuses.destroy')
    ->middleware(['permission:delete_vendor_statuses']);

  	Route::get('deletes'	,'VendorStatusController@deletes')
  	->name('dashboard.vendor_statuses.deletes')
    ->middleware(['permission:delete_vendor_statuses']);

  	Route::get('{id}','VendorStatusController@show')
  	->name('dashboard.vendor_statuses.show')
    ->middleware(['permission:show_vendor_statuses']);

});
