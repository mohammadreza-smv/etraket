<?php
$mapLinks=[
    ['title'=>'محصولات فروشندگان دنبال شده','link'=>url('seller/followed/products')]
]
?>
@include('front-theme::views.cat_product',[
    'mapLinks'=>$mapLinks,
])
