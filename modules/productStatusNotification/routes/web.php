<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('notification/products','NotificationController@products');

    Route::match(['get','post'],'notification/product/setting','NotificationController@setting');

});

Route::middleware(['auth'])->group(function (){
    Route::post('product/notification-status/add/notification','ApiController@addNotification');
    Route::post('product/notification-status/remove-request','ApiController@remove_request');
});
