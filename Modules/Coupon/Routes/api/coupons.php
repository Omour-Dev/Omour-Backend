<?php

Route::group(['prefix' => 'coupons'], function () {

    Route::post('/'   , 'CouponController@checkCoupon')->name('api.coupons.check');

});
