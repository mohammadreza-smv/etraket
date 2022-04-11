<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    create_crud_route('product/price_variation','PriceVariationController');

    Route::get('category/{id}/price_variation','PriceVariationItemController@priceVariationItems')->name('priceVariationItems');
    Route::post('category/{id}/price_variation','PriceVariationItemController@add_price_variation')->name('add_price_variation');
    Route::delete('category/price_variation/{id}','PriceVariationItemController@destroy')->name('price_variation.destroy');

});

Route::post('shop/change_product_variation','ShopController@change_product_variation');
