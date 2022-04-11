<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    create_crud_route('blog/categories','BlogCategoriesController');
    create_crud_route('blog/posts','BlogPostsController');
    Route::match(['get','post'],'blog/domain','SettingController@domain');
});


$subdomain=config('blog.subdomain',null);
$blogUrl=config('blog.url');
if($subdomain==='true'){
    $url=$blogUrl.'.'.url('');
    $url=str_replace('www.','',$url);
    $url=str_replace('http://','',$url);
    $url=str_replace('https://','',$url);
    Route::domain($url)->group(function () {
        Route::get('/','BlogController@index')->name('blog.index');
        Route::get('/category/{cat1}/{cat2?}','BlogController@cat_posts')->name('blog.cat.posts');
        Route::get('/post/{url}','BlogController@post')->name('blog.show.post');
    });
}
else{
    Route::prefix($blogUrl)->group(function (){
        Route::get('/','BlogController@index')->name('blog.index');
        Route::get('/category/{cat1}/{cat2?}','BlogController@cat_posts')->name('blog.cat.posts');
        Route::get('/post/{url}','BlogController@post')->name('blog.show.post');
    });
}
