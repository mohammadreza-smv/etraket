<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    create_crud_route('category-common-question','CategoryCommonQuestionController');
    create_crud_route('common-question','CommonQuestionController');
});
Route::get('/faq','ShopController@faq')->name('faq');
Route::get('faq/category/{id}','ShopController@faq_category')->name('faq.category');
Route::get('faq/question/{id}','ShopController@faq_question')->name('faq.question');
