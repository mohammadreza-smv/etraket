<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    Route::get('statistics/week/visit/{year?}','StatisticsControllers@week_visit');
    Route::get('statistics/month/visit','StatisticsControllers@month_visit');
    Route::get('statistics/product/{product_id}/visit','StatisticsControllers@product_visit');

    Route::get('product/visit/{product_id}','StatisticsControllers@product_visit_view')->name('product.visit');
});

