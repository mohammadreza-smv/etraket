<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    create_crud_route('pages','PageController');
});

Route::get('page/{page}','ShopController@page')->name('show.page');
