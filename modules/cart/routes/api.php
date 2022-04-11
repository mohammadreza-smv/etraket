<?php


Route::post('app/getCartData','ApiController@getCartData');


Route::middleware('auth:api')->group(function (){

    Route::post('app/cart/remove_product','ApiController@remove_product');
    Route::get('app/cart/update_cart_table','ApiController@update_cart_table');
    Route::post('app/cart/change_product_count_of_table','ApiController@change_product_count_of_table');
});
