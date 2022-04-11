<?php


Route::post('app/product/comments','ApiController@comments');


Route::middleware('auth:api')->group(function (){

    Route::post('app/comment/create','ApiController@create');

    Route::post('app/user/comments','ApiController@userCreate');
});
