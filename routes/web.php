<?php

use Modules\cart\Models\ShoppingCart;

Route::get('sitemap-category.xml','SiteController@sitemap_category');
Route::get('sitemap.xml','SiteController@sitemap');
Route::get('products/{page}/sitemap-products.xml','SiteController@sitemap_products');

//Route::get('order/verify/{order_id}','ShoppingController@order_verify')->middleware('auth');

