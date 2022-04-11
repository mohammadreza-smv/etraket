<?php

Route::get('chart/price-changes-detail/{product_id}',function ($product_id){
    return get_product_price_changed($product_id);
});
