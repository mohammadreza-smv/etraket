<?php

Route::get('/', 'SiteController@index')->name('home');

Route::get('product/{product_id}/{product_url}','SiteController@show_product')->name('show_product');
Route::get('product/{product_id}','SiteController@show_product')->name('show_product');

Route::get('main/{cat_url}','SiteController@show_child_cat_list')->name('main_cat');
Route::get('search/{cat_url}','SiteController@cat_product')->name('cat_product');
Route::get('getProduct/search/{cat_url}','SiteController@get_cat_product');
Route::get('shop/product-list','SiteController@product_list');
Route::post('site/share_product','SiteController@share_product');
Route::get('search','SiteController@search_product');
Route::get('getProduct/search','SiteController@get_search_product');

Route::post('shop/set-shop-cites','SiteController@set_shop_cites');
