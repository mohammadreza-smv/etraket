<?php

Route::post('seller/first_step_register','ApiController@first_step_register')->middleware('seller_guest');

Route::post('seller/second_step_register','ApiController@second_step_register')->middleware('seller_guest');

Route::post('seller/check_active_code','ApiController@check_active_code')->middleware('seller_guest');

Route::post('seller/resend_active_code','ApiController@resend_active_code')->middleware('seller_guest');

Route::post('seller/upload_file','ApiController@upload_document')->middleware('seller_guest');

