<?php

Route::group(['prefix' => 'areas'], function () {

  	Route::get('/' ,'AreaController@index')
  	->name('dashboard.areas.index')
    ->middleware(['permission:show_areas']);

  	Route::get('datatable'	,'AreaController@datatable')
  	->name('dashboard.areas.datatable')
  	->middleware(['permission:show_areas']);

  	Route::get('create'		,'AreaController@create')
  	->name('dashboard.areas.create')
    ->middleware(['permission:add_areas']);

  	Route::post('/'			,'AreaController@store')
  	->name('dashboard.areas.store')
    ->middleware(['permission:add_areas']);

  	Route::get('{id}/edit'	,'AreaController@edit')
  	->name('dashboard.areas.edit')
    ->middleware(['permission:edit_areas']);

  	Route::put('{id}'		,'AreaController@update')
  	->name('dashboard.areas.update')
    ->middleware(['permission:edit_areas']);

  	Route::delete('{id}'	,'AreaController@destroy')
  	->name('dashboard.areas.destroy')
    ->middleware(['permission:delete_areas']);

  	Route::get('deletes'	,'AreaController@deletes')
  	->name('dashboard.areas.deletes')
    ->middleware(['permission:delete_areas']);

  	Route::get('{id}','AreaController@show')
  	->name('dashboard.areas.show')
    ->middleware(['permission:show_areas']);

});
