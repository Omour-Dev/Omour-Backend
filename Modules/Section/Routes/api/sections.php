<?php

Route::group(['prefix' => 'sections'], function () {

    Route::get('/'      , 'SectionController@sections')->name('api.sections.index');
    Route::get('{id}'   , 'SectionController@section')->name('api.sections.show');

});
