<?php

Route::prefix('user')->middleware(['auth','user'])->group(function (){

    Route::get('getFavoriteList','FavoriteController@getFavoriteList');
    Route::post('/add_favorite','FavoriteController@add_favorite');
    Route::get('profile/favorite','ShopController@favorite')->name('user.favorite');
    Route::post('favorite/list/remove','FavoriteController@removeProductOfList');
});
