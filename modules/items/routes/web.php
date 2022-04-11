<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('category/{id}/items','ItemController@items')->name('category.items');
    Route::post('category/{id}/item','ItemController@add_items')->name('category.add_items');
    Route::delete('category/items/{id}','ItemController@destroy')->name('category.item.destroy');

    Route::get('products/{id}/items','ItemController@product_items')->name('product.items');
    Route::post('products/{id}/items','ItemController@add_product_items')->name('add.product.items');

});
