<?php

Route::prefix('admin')->middleware(['auth','user'])->group(function (){

    Route::get('themes/widget-list','ThemeController@widget_list');

    Route::get('themes/widgets','ThemeController@widgets')->name('theme.widgets');

    Route::post('theme/design/save-data','ThemeController@save_design_data');

    Route::get('theme/design/get-position-data/{position}','ThemeController@get_position_data');
});
