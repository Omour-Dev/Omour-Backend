<?php

Route::group(['prefix' => 'roles'], function () {

  	Route::get('/' ,'RoleController@index')
  	->name('dashboard.roles.index')
    ->middleware(['permission:show_roles']);

  	Route::get('datatable'	,'RoleController@datatable')
  	->name('dashboard.roles.datatable')
  	->middleware(['permission:show_roles']);

  	Route::get('create'		,'RoleController@create')
  	->name('dashboard.roles.create')
    ->middleware(['permission:add_roles']);

  	Route::post('/'			,'RoleController@store')
  	->name('dashboard.roles.store')
    ->middleware(['permission:add_roles']);

  	Route::get('{id}/edit'	,'RoleController@edit')
  	->name('dashboard.roles.edit')
    ->middleware(['permission:edit_roles']);

  	Route::put('{id}'		,'RoleController@update')
  	->name('dashboard.roles.update')
    ->middleware(['permission:edit_roles']);

  	Route::delete('{id}'	,'RoleController@destroy')
  	->name('dashboard.roles.destroy')
    ->middleware(['permission:delete_roles']);

  	Route::get('deletes'	,'RoleController@deletes')
  	->name('dashboard.roles.deletes')
    ->middleware(['permission:delete_roles']);

  	Route::get('{id}','RoleController@show')
  	->name('dashboard.roles.show')
    ->middleware(['permission:show_roles']);

});
