<?php

Route::middleware('auth:api')->group(function () {

    Route::post('user/address/store','ApiController@addAddress');

    Route::post('user/address/edit/{address_id}','ApiController@update_address');

    Route::get('user/address/list','ApiController@address_list');

    Route::post('user/address/remove','ApiController@remove_address');

    Route::get('user/address/list','ApiController@address_list');

});
