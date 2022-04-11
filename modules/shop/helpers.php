<?php

use Modules\shop\Models\SearchProduct;

function shop_product_url($product){
    return url('product/dkp-'.$product->id.'/'.$product->product_url);
}

function shop_short_product_url($product){
    return url('product/dkp-'.$product->id);
}

function shop_product_url_theme(){
    return url('').'/product/dkp-:id/:product_url';
}
function getDiscountValue($price1,$price2){
    $d=($price2/$price1)*100;
    $d=100-$d;
    $d=round($d);
    return $d;
}

function searchProducts($catQuery=[]): array
{
    $request=request();
    $categoryRepository=app(\Modules\categories\Repository\CategoryRepositoryInterface::class);
    $products=new SearchProduct($request,$categoryRepository);
    return $products->getProduct();
}
