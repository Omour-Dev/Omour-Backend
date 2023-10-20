<?php

use Vsch\TranslationManager\Translator;


Route::group(['prefix' => '/' , 'middleware' => ['dashboard.auth','permission:dashboard_access']], function() {

  Route::get('/' , 'DashboardController@index')->name('dashboard.home');

  Route::group(['prefix' => 'translations'], function () {
      Translator::routes();
  });

  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
