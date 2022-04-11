<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    Route::get('product/review/primary','ReviewController@primary')->name('review.primary');
    Route::post('product/review/primary','ReviewController@add_primary_content')->name('review.add.primary');
    create_crud_route('product/review','ReviewController');
});
