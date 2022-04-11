<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    Route::match(['get','post'],'setting/shop','SettingController@shop')->name('shop.setting');
    Route::match(['get','post'],'setting/payment-gateway','SettingController@payment_gateway');
});
