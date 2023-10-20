<?php

Route::group(['prefix' => 'options'], function () {

    Route::get('options-by-vendor' ,'OptionController@optionByVendor')
    ->name('dashboard.options-by-vendor')
    ->middleware(['permission:show_options']);

  	Route::get('/' ,'OptionController@index')
  	->name('dashboard.options.index')
    ->middleware(['permission:show_options']);

  	Route::get('datatable'	,'OptionController@datatable')
  	->name('dashboard.options.datatable')
  	->middleware(['permission:show_options']);

  	Route::get('create'		,'OptionController@create')
  	->name('dashboard.options.create')
    ->middleware(['permission:add_options']);

  	Route::post('/'			,'OptionController@store')
  	->name('dashboard.options.store')
    ->middleware(['permission:add_options']);

  	Route::get('{id}/edit'	,'OptionController@edit')
  	->name('dashboard.options.edit')
    ->middleware(['permission:edit_options']);

  	Route::put('{id}'		,'OptionController@update')
  	->name('dashboard.options.update')
    ->middleware(['permission:edit_options']);

  	Route::delete('{id}'	,'OptionController@destroy')
  	->name('dashboard.options.destroy')
    ->middleware(['permission:delete_options']);

  	Route::get('deletes'	,'OptionController@deletes')
  	->name('dashboard.options.deletes')
    ->middleware(['permission:delete_options']);

  	Route::get('{id}','OptionController@show')
  	->name('dashboard.options.show')
    ->middleware(['permission:show_options']);

});
