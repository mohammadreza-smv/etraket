<?php

Route::post('user/register','ApiController@register');

Route::post('user/send/activeCode','ApiController@check_active_code');

Route::post('user/resend/activeCode','ApiController@resend_active_code');

Route::middleware('auth:api')->group(function (){

    Route::get('app/user/global/data','ApiController@user_global_detail');

    Route::post('user/logout','ApiController@logout');

});
