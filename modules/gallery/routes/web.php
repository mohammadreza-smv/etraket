<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    Route::get('products/gallery/{id}','GalleryController@gallery')->name('product.gallery');
    Route::post('products/gallery_upload/{id}','GalleryController@gallery_upload')->name('product.add_gallery');
    Route::delete('products/gallery/{id}/{product_id}','GalleryController@removeImageGallery')->name('product.remove_gallery');
    Route::post('products/change_images_status/{id}/{product_id}','GalleryController@change_images_status')->name('product.gallery_change_status');
});
