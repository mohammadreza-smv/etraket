<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    create_crud_route('comments','CommentController',['show','create','store','edit','update']);
    Route::post('comment/change_status','CommentController@change_status')->name('comment_change_status');

});


Route::get('product/comment/create/{product_id}/','ShopController@comment_form')->name('comment_form')->middleware('auth');
Route::post('product/comment/create/{product_id}','ShopController@add_comment')->middleware('auth');
Route::get('user/profile/comments','ShopController@comments')->middleware('auth')->name('user_comments');

Route::get('site/getComment','CommentController@getComment');

Route::post('user/comment/score/{type}','ShopController@set_score')->middleware('auth');

Route::get('comments/last/{product_id}','ApiController@lastComments');
