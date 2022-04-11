<?php


Route::middleware('auth:api')->group(function (){
    Route::post('favourite/add_or_remove','ApiController@add_or_remove');
    Route::get('user/favourite/list','ApiController@favourite_list');
    Route::post('user/favourite/remove','ApiController@remove_favourite');
});
