<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('category/{id}/filters','FilterController@filters')->name('filter_list');
    Route::post('category/{id}/filters','FilterController@add_filters')->name('add_filters');
    Route::delete('category/filters/{id}','FilterController@destroy')->name('filters.destroy');

    Route::get('products/{id}/filters','FilterController@product_filters')->name('product.filters');
    Route::post('products/{id}/filters','FilterController@add_product_filters')->name('product.add_filters');

});

