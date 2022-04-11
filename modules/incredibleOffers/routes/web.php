<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('product/incredible-offers/{id}/add','IncredibleOffersController@create')
        ->name('incredible.offers.add');

    Route::put('incredible-offers/{id}','IncredibleOffersController@update');

    Route::get('incredible-offers','IncredibleOffersController@offers_list')
        ->name('incredible.offers.list');

    Route::delete('incredible-offers/{id}','IncredibleOffersController@remove');

});
