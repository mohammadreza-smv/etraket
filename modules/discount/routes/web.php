<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    create_crud_route('discount','DiscountController');

});

Route::post('site/check_discount_code','DiscountController@check_discount_code');
