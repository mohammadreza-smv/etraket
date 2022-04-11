<?php

Route::post('get_compare_products','ShopController@get_compare_products');

Route::get('compare/{productId1}','ShopController@compare')->name('product.compare');
Route::get('compare/{productId1}/{productId2}','ShopController@compare')->name('product.compare');
Route::get('compare/{productId1}/{productId2}/{productId3}','ShopController@compare')->name('product.compare');
Route::get('compare/{productId1}/{productId2}/{productId3}/{productId4}','ShopController@compare')->name('product.compare');

Route::post('site/getCatBrand','ShopController@getCatBrand');
