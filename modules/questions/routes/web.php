<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function () {

    create_crud_route('questions','QuestionController',['show','create','store','edit','update']);
    Route::post('question/change_status','QuestionController@change_status')->name('change_question_status');
    Route::post('question/addAnswer/{id}','QuestionController@addAnswer')->name('questions_addAnswer');

});

Route::get('site/get_question/{product_id}','ShopController@get_question');

Route::prefix('user')->middleware(['auth'])->group(function (){

    Route::post('addQuestion','ShopController@addQuestion');

    Route::post('/question/score/{type}','ShopController@set_score');
});

Route::get('question/last/{product_id}','ApiController@lastQuestion');
