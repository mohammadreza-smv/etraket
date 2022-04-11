<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::match(['get','post'],'setting/gateway/zarinpal','GatewayController@setting');

});
