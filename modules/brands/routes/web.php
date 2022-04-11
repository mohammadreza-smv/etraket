<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    create_crud_route('brands','BrandController');
});

Route::get('brand/{brand_name}','ShopController@show_products');

Route::get('getProduct/brand/{brand_name}','ShopController@get_product');
