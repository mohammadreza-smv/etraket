<?php

Route::get('app/products','AppController@product_list');

Route::get('product/detail/{id}','AppController@product');

Route::get('product/relate/{id}','AppController@relate_products');

Route::post('product/price_variation/check_has','AppController@check_has_price_variation');

Route::get('app/categories','AppController@categories');

Route::get('app/child-categories/{catId}','AppController@child_categories');

Route::get('app/category/new_product/{catId}','AppController@category_new_product');

Route::get('app/category/best_selling_product/{catId}','AppController@category_best_selling_product');

Route::post('app/user/check_discount_code','AppController@check_discount_code');

Route::post('product/getList','AppController@getProductList');

Route::get('category/filters/{cat_id}','AppController@getFilters');

Route::get('app/incredible_offers','AppController@incredible_offers');

Route::get("app/search/product",'AppController@search_product');

Route::get('home/screen/design','AppController@home_screen_design');

Route::middleware('auth:api')->group(function (){

    Route::get('app/user/check_order_register_condition','AppController@check_order_register_condition');

    Route::post('user/add/register_detail','AppController@add_register_detail');

    Route::get('shipping/getSendData/{city_id}','AppController@getCartData');

    Route::get('app/user/panel/data','AppController@panel_data');

    Route::post('user/profile/changePassword','AppController@changePassword');

    Route::post('user/add_order','AppController@add_order');

});
