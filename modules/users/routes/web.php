<?php


Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('/','AdminController@index')->name('admin.index');
    create_crud_route('userRole','UserRoleController');
    Route::get('userRole/access/{role_id}','UserRoleController@access');
    Route::post('userRole/access/{role_id}','UserRoleController@add_access');
    create_crud_route('users','UsersController',[]);
    Route::match(['get','post'],'user/sms/channel','UsersController@sms_setting');

    Route::get('/403','AdminController@error403')->name('error403');
});

Route::get('/confirm','Auth\RegisterController@confirm')->middleware('guest');

Route::get(config('shop-info.login_url'),'auth\LoginController@admin_login_form')->middleware('guest');

Auth::routes();

Route::get('password/confirm','Auth\ForgotPasswordController@confirm')->middleware('guest');
Route::post('password/confirm','Auth\ForgotPasswordController@check_confirm_code')->middleware('guest');

Route::post('register/active_account','Auth\RegisterController@active_account')->name('active_account');

Route::post('register/ajax/resend','ApiController@resend')->name('sms.resend');

Route::prefix('user')->middleware(['auth'])->group(function (){
    Route::get('profile','UserPanelController@profile')->name('user.profile');
    Route::get('profile/additional-info','UserPanelController@additional_info');
    Route::post('profile/additional-info','UserPanelController@save_additional_info');
    Route::get('profile/confirm-mobile','UserPanelController@confirmMobile');
    Route::post('change-mobile-number','UserPanelController@changeMobileNumber');
    Route::post('add/register_detail','ApiController@add_register_detail');
    Route::post('mobile/update','ApiController@update_mobile');
    Route::post('bankCard/update','ApiController@update_bankCard');
    Route::post('nationalIdentityNumber/update','ApiController@update_national_identity_number');
    Route::post('email/update','ApiController@email_number');
    Route::post('date-of-birth/update','ApiController@updateDateOfBirth');
});
