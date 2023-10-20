<?php

Route::group(['prefix' => 'products'], function () {

  	Route::get('/' ,'ProductController@index')
  	->name('dashboard.products.index')
    ->middleware(['permission:show_products']);

    Route::get('reports' ,'ProductController@reports')
    ->name('dashboard.products.reports')
    ->middleware(['permission:show_products']);

  	Route::get('datatable'	,'ProductController@datatable')
  	->name('dashboard.products.datatable')
  	->middleware(['permission:show_products']);

  	Route::get('create'		,'ProductController@create')
  	->name('dashboard.products.create')
    ->middleware(['permission:add_products']);

  	Route::post('/'			,'ProductController@store')
  	->name('dashboard.products.store')
    ->middleware(['permission:add_products']);

  	Route::get('{id}/edit'	,'ProductController@edit')
  	->name('dashboard.products.edit')
    ->middleware(['permission:edit_products']);

  	Route::put('{id}'		,'ProductController@update')
  	->name('dashboard.products.update')
    ->middleware(['permission:edit_products']);

    Route::get('{id}/clone'	,'ProductController@clone')
  	->name('dashboard.products.clone')
    ->middleware(['permission:add_products']);

  	Route::delete('{id}'	,'ProductController@destroy')
  	->name('dashboard.products.destroy')
    ->middleware(['permission:delete_products']);

  	Route::get('deletes'	,'ProductController@deletes')
  	->name('dashboard.products.deletes')
    ->middleware(['permission:delete_products']);

  	Route::get('{id}','ProductController@show')
  	->name('dashboard.products.show')
    ->middleware(['permission:show_products']);

});
