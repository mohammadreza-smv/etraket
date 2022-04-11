<?php
    $mapLinks=[
        ['title'=>$brand->brand_name,'link'=>url('brand/'.$brand->brand_ename)]
    ]
?>
@include('front-theme::views.cat_product',[
    'before_filter'=>'brands::shop.brand-info',
    'mapLinks'=>$mapLinks
])