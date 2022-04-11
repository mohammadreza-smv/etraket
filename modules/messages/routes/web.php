<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    $types=CompleteData('add_message_type',[
        'Modules\users\Models\User'=>[
            'url_param'=>'users',
            'attr'=>'name'
        ]
    ]);

    foreach ($types as $type){
        $param=substr($type['url_param'],0,(strlen($type['url_param'])-1));
        create_crud_route($type['url_param'].'/{'.$param.'_id}/messages', 'UserMessageController',['edit','update'],['names'=>$param.'.message']);
        Route::put($type['url_param'].'/{'.$param.'_id}/messages/{message_id}', 'UserMessageController@addAnswer')->name($param.'.message.answer');
    }
    create_crud_route('messages', 'MessageController',['edit','update','create','store']);
    Route::put('messages/addAnswer/{id}','MessageController@addAnswer');

});

Route::prefix('user')->middleware(['auth','user'])->group(function (){
    Route::get('profile/messages', 'UserPanelController@getUserMessage')->name('user.message.list');
    Route::post('profile/messages', 'UserPanelController@addMessage');
    Route::get('profile/messages/create', 'UserPanelController@addMessageForm')->name('user.message.create');
    Route::get('profile/messages/{id}','UserPanelController@showMessageContent')->name('user.message.content');
    Route::put('profile/messages/addAnswer/{id}', 'UserPanelController@addAnswer');
});
