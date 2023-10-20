<?php

Route::group(['prefix' => 'orders'], function () {

    Route::get('calendar' ,'OrderController@calendar')
  	->name('vendor.orders.calendar');

  	Route::get('/' ,'OrderController@index')
  	->name('vendor.orders.index');

  	Route::get('datatable'	,'OrderController@datatable')
  	->name('vendor.orders.datatable');

  	Route::get('create'		,'OrderController@create')
  	->name('vendor.orders.create');

  	Route::post('/'			,'OrderController@store')
  	->name('vendor.orders.store');

  	Route::get('{id}/edit'	,'OrderController@edit')
  	->name('vendor.orders.edit');

  	Route::put('{id}'		,'OrderController@update')
  	->name('vendor.orders.update');

  	Route::delete('{id}'	,'OrderController@destroy')
  	->name('vendor.orders.destroy');

  	Route::get('deletes'	,'OrderController@deletes')
  	->name('vendor.orders.deletes');

  	Route::get('{id}','OrderController@show')
  	->name('vendor.orders.show');

});
