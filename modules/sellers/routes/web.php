<?php

Route::prefix('admin/sellers')->middleware(['auth','user'])->group(function (){


    create_crud_route('list', 'SellerController',['create','store']);

    Route::get('payments', 'SellerController@payments')->name('payments');

    Route::get('pay/export', 'SellerController@export');
    Route::get('pay/import', 'SellerController@import');
    Route::post('pay/import', 'SellerController@add_payment');

    create_crud_route('commissions','CommissionController');

    Route::match(['get','post'],'sms/channel','SellerController@sms_setting');

    Route::get('{seller_id}/statistics','SellerController@statistics');
    Route::get('statistics/{seller_id}','SellerController@get_statistics');
});



Route::post('seller/follow','SiteController@follow')->middleware('auth');
Route::get('seller/{seller_id}/lats-products','SiteController@seller_last_product');

Route::prefix('sellers')->group(function (){

    //auth routes
    Route::post('login','LoginController@login')->middleware('seller_guest');
    Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')
        ->middleware('seller_guest');
    Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')
        ->middleware('seller_guest');

    Route::post('password/confirm','Auth\ForgotPasswordController@check_confirm_code')
        ->middleware('seller_guest');

    Route::post('password/reset','Auth\ResetPasswordController@reset')
        ->middleware('seller_guest');

    Route::get('register','AuthController@register_form')
        ->name('seller.register.form')->middleware('seller_guest');

    Route::get('login','AuthController@login_form')
        ->name('seller.login.form')->middleware('seller_guest');

});

Route::prefix('sellers/panel')->middleware(['seller_auth'])->group(function (){

    Route::get('/','PanelController@index');


    Route::get('messages','SellerMessageController@index')->name('user.message.list');
    Route::get('messages/{id}','SellerMessageController@showMessageContent')->name('user.message.content');
    Route::put('messages/addAnswer/{id}', 'SellerMessageController@addAnswer');
    Route::get('message/create', 'SellerMessageController@addMessageForm')->name('user.message.create');
    Route::post('message', 'SellerMessageController@store');

    Route::post('logout','PanelController@logout');

    Route::middleware(['check_seller_account'])->group(function (){

        Route::resource('products','ProductsController',[
            'create'=>'products.create',
            'store'=>'products.store',
            'destroy'=>'products.destroy',
            'edit'=>'products.edit',
            'update'=>'products.update'
        ])->except(['show']);

        Route::get('products/total/show','ProductsController@total_product');

        create_crud_route('product/price_variation','PriceVariationController');

        Route::get('get_month_sales_statistics','ApiController@get_month_sales_statistics');

        //orders route
        Route::get('orders','PanelController@orders');

        Route::get('orders/{id}','PanelController@show_order_content');

        //gallery route
        Route::get('products/gallery/{product_id}','ProductsController@gallery')->name('product.gallery');;
        Route::post('products/gallery_upload/{id}','ProductsController@gallery_upload')->name('product.add_gallery');
        Route::delete('products/gallery/{id}/{product_id}','ProductsController@removeImageGallery')->name('product.remove_gallery');
        Route::post('products/change_images_status/{id}','ProductsController@change_images_status')->name('product.gallery_change_status');

        //items route
        Route::get('products/{id}/items','ProductsController@product_items')->name('product.items');
        Route::post('products/{id}/items','ProductsController@add_product_items')->name('add.product.items');

        //statistics
        Route::get('payment','PanelController@payment')->name('seller.payment');

    });

    //profile
    Route::get('profile','PanelController@profile')->name('seller.profile');
    Route::put('profile/{id}','PanelController@edit_profile')->name('seller.edit_profile');
    Route::post('profile/check_active_code','PanelController@profile_active_code');

});

Route::get('seller/{id}','SiteController@product_list')->name('seller.page');
Route::get('getProduct/seller/{id}','SiteController@search_product');

Route::get('seller/followed/products','SiteController@followed_products');
Route::get('getProduct/seller/followed/products','SiteController@search_followed_products');
