<?php

Route::prefix('user')->middleware(['auth','user'])->group(function (){
    Route::get('getAddress','AddressController@getAddress');
    Route::post('/addAddress','AddressController@create');
    Route::post('/updateAddress','AddressController@update');
    Route::delete('/removeAddress/{address_id}','AddressController@destroy');
    Route::get('profile/address','UserController@address')->name('profile.address');
});
