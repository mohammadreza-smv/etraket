<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('/panel','AdminController@author_panel')->name('author_panel');


    Route::get('orders/return-product','OrdersController@return_product_list')->name('orders.return-product-list');
    Route::post('orders/return-product','OrdersController@remove_return_product')->name('orders.remove-return-product');

    Route::get('orders/submission/factor/{submission_id}','OrdersController@submission_foctor')->name('submissions_factor');
    Route::get('orders/return-product/{id}','OrdersController@return_product')->name('return-product');
    Route::post('orders/return-product/{id}','OrdersController@add_return_product')->name('return-product');

    Route::get('stockroom/input','StockroomController@input')->name('stockroom.input');
    Route::get('stockroom/input/{id}','StockroomController@show_input')->name('stockroom.show_input');
    Route::post('stockroom/add_product','StockroomController@add_product')->name('stockroom.add_product');
    Route::get('stockroom/add/input','StockroomController@add_input')->name('stockroom.add_input');

    Route::get('stockroom/output','StockroomController@output')->name('stockroom.output');
    Route::get('stockroom/output/{id}','StockroomController@show_output')->name('stockroom.show_output');
    Route::post('stockroom/add_output','StockroomController@add_product')->name('stockroom.add_product');
    Route::get('stockroom/add/output','StockroomController@add_output')->name('stockroom.add_output');
    Route::get('factor/{id}/input','StockroomController@input_factor')->name('stockroom.input_factor');
    Route::get('factor/{id}/output','StockroomController@output_factor')->name('stockroom.output_factor');

    create_crud_route('packages','PackageController',['create','store','edit','update']);
    Route::get('package/getContent/{id}','PackageController@getContent');
    Route::post('package/stockroom/add_product','PackageController@add_product');

    create_crud_route('stockrooms','StockroomController',[]);
    Route::get('stockroom/getProductWarrnty','StockroomController@getProductWarrnty')->name('get_product_warrnty');
    Route::get('stockroom/getInventory','StockroomController@getInventory')->name('get_inventory');
    Route::get('report/sale','AdminController@sale_report')->name('sale_report');
    Route::get('shop/get_sale_report','AdminController@get_sale_report')->name('get_sale_report');
   // Route::get('product/get_sale_report','ProductController@get_sale_report');

});
