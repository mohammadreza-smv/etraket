<?php

namespace Modules\sellers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\sellers\Repository\SellerRepositoryInterface;
class SiteController extends Controller
{
    public function product_list(Request $request,$seller_id,SellerRepositoryInterface $sellerRepository){
        config()->set('view.search_components',true);
        $result=searchProducts();
        $seller=$sellerRepository->find($seller_id);
        $follow=$sellerRepository->checkUserFollow($seller_id);
        $followers_count=$sellerRepository->followers_count($seller_id);
        return CView('sellers::site.'.$this->view.'products',compact('result','seller','follow','followers_count'));
    }

    public function search_product(){
        return searchProducts();
    }

    public function follow(Request $request,SellerRepositoryInterface $sellerRepository){
        return $sellerRepository->follow($request);
    }

    public function seller_last_product($seller_id,SellerRepositoryInterface $sellerRepository){
        return $sellerRepository->lastProducts($seller_id);
    }

    public function followed_products(){
        config()->set('view.search_components',true);
        $result=searchProducts();
        return CView('sellers::site.'.$this->view.'followed_products',compact('result'));
    }

    public function search_followed_products(){
        return searchProducts();
    }
}
