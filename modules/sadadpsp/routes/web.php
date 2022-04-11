<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::match(['get','post'],'setting/gateway/sadadpsp','GatewayController@setting');

});
