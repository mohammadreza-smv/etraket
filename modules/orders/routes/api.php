<?php

Route::middleware('auth:api')->group(function (){

    Route::get('app/user/orders/{type}','ApiController@order_list');

    Route::get('app/user/order/content/{id}','ApiController@order_content');

});
