<?php

Route::group(['prefix' => 'order-statuses'], function () {

  	Route::get('/' ,'OrderStatusController@index')
  	->name('dashboard.order-statuses.index')
    ->middleware(['permission:show_order_statuses']);

  	Route::get('datatable'	,'OrderStatusController@datatable')
  	->name('dashboard.order-statuses.datatable')
  	->middleware(['permission:show_order_statuses']);

  	Route::get('create'		,'OrderStatusController@create')
  	->name('dashboard.order-statuses.create')
    ->middleware(['permission:add_order_statuses']);

  	Route::post('/'			,'OrderStatusController@store')
  	->name('dashboard.order-statuses.store')
    ->middleware(['permission:add_order_statuses']);

  	Route::get('{id}/edit'	,'OrderStatusController@edit')
  	->name('dashboard.order-statuses.edit')
    ->middleware(['permission:edit_order_statuses']);

  	Route::put('{id}'		,'OrderStatusController@update')
  	->name('dashboard.order-statuses.update')
    ->middleware(['permission:edit_order_statuses']);

  	Route::delete('{id}'	,'OrderStatusController@destroy')
  	->name('dashboard.order-statuses.destroy')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('deletes'	,'OrderStatusController@deletes')
  	->name('dashboard.order-statuses.deletes')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('{id}','OrderStatusController@show')
  	->name('dashboard.order-statuses.show')
    ->middleware(['permission:show_order_statuses']);

});
