<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    create_crud_route('orders/submissions','SubmissionController',['create','store','edit','update']);

    $orderStatus=\Modules\orders\Models\Orders::OrderStatus();
    foreach ($orderStatus as $array){
        Route::get('orders/submissions/send_type/'.$array['value'],'SubmissionController@submissions')
            ->name('submissions_'.$array['value'].'_send_type');
    }

    create_crud_route('orders','OrdersController',['create','store','edit','update']);
    Route::post('order/change_status','OrdersController@change_status')->name('order.change_status');

    Route::get('order/{order_id}/factor','OrdersController@factor')->name('order.factor');

    Route::get('order/index-chart-data','OrdersController@index_chart_data');

});

Route::post('order/payment','ShopController@order_payment');

Route::prefix('user')->middleware(['auth'])->group(function (){

    Route::get('profile/orders','UserPanelController@orders')->name('userpanel.order');
    Route::get('profile/order/json/list','UserPanelController@json_orders')->name('userpanel.json_order');
    Route::get('profile/order/{order_id}','UserPanelController@show_order')->name('user.show_order');
    Route::get('profile/order/{order_id}/factor','UserPanelController@order_factor');

});
