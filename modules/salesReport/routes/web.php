<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('/sales/province','SaleController@province')->name('province.sale');
});
