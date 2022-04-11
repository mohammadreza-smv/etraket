<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    Route::match(['get','post'],'setting/order/send-price','SettingController@send_order_price');
    create_crud_route('setting/sending_type','OrderSendTypeController');
});
