<?php

Route::group(['prefix' => 'users'], function () {

  	Route::get('/' ,'UserController@index')
  	->name('dashboard.users.index')
    ->middleware(['permission:show_users']);

  	Route::get('datatable'	,'UserController@datatable')
  	->name('dashboard.users.datatable')
  	->middleware(['permission:show_users']);

  	Route::get('create'		,'UserController@create')
  	->name('dashboard.users.create')
    ->middleware(['permission:add_users']);

  	Route::post('/'			,'UserController@store')
  	->name('dashboard.users.store')
    ->middleware(['permission:add_users']);

  	Route::get('{id}/edit'	,'UserController@edit')
  	->name('dashboard.users.edit')
    ->middleware(['permission:edit_users']);

  	Route::put('{id}'		,'UserController@update')
  	->name('dashboard.users.update')
    ->middleware(['permission:edit_users']);

  	Route::delete('{id}'	,'UserController@destroy')
  	->name('dashboard.users.destroy')
    ->middleware(['permission:delete_users']);

  	Route::get('deletes'	,'UserController@deletes')
  	->name('dashboard.users.deletes')
    ->middleware(['permission:delete_users']);

  	Route::get('{id}','UserController@show')
  	->name('dashboard.users.show')
    ->middleware(['permission:show_users']);

});
