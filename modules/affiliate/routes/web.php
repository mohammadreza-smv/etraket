<?php

Route::prefix('admin/affiliate')->middleware(['auth','user'])->group(function (){

    create_crud_route('commissions','AffiliateCommissionController');

});
