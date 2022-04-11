<?php

Route::post('Cart','CartController@add_cart');
Route::get('Cart','CartController@show_cart')->name('cart');

Route::post('site/cart/remove_product','CartController@remove_product');
Route::post('site/cart/change_product_cart','CartController@change_product_cart');
Route::get('site/CartProductData','CartController@cartProductData');

Route::post('site/cart/change_cart_product_type','CartController@change_cart_product_type')->middleware('auth');

Route::match(['get','post'],'order/verify','ShoppingController@verify');

Route::middleware(['auth'])->group(function (){
    Route::get('shipping','ShoppingController@shipping')->name('shipping.set_data');
    Route::get('shipping/getSendData/{city_id}','ShoppingController@getCartData');
    Route::match(['post','get'],'payment','ShoppingController@payment')->name('cart.payment');
});

