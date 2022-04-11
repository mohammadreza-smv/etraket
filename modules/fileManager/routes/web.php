<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){
    Route::get('filemanager','FileManagerController@filemanager')->name('filemanager');
    Route::get('filemanager/dirList/{path}','FileManagerController@dirList');
    Route::post('filemanager/fileList','FileManagerController@fileList');
    Route::post('filemanager/upload','FileManagerController@upload');
    Route::post('filemanager/removeFile','FileManagerController@removeFile');
});
