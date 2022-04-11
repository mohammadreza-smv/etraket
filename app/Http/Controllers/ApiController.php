<?php

namespace App\Http\Controllers;

use App\City;
use App\Comment;
use App\ProductWarranty;
use App\Province;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_province()
    {
        return Province::orderBy('id','ASC')->get();
    }
    public function like(Request $request)
    {
        return addLike($request,'like');
    }
    public function dislike(Request $request)
    {
        return addLike($request,'dislike');
    }
    public function getComment(Request $request)
    {
        $product_id=$request->get('product_id',0);
        $orderBy=$request->get('orderBy',1);
        $comments=Comment::getProductCommentList($product_id,$orderBy);
        return $comments;
    }
//    public function getProductPriceChart($product_id)
//    {
//       return get_product_price_changed($product_id);
//    }
    public function getProductChartData($product_id)
    {
        return get_product_price_changed($product_id);
    }
    public function getWarranty(Request $request,$product_id)
    {
        $color_id=$request->get('color_id',0);

        return ProductWarranty::where(['product_id'=>$product_id,'color_id'=>$color_id])
            ->orderBy('price2','ASC')
            ->with('getSeller:id,brand_name')
            ->with('getWarranty')->get();
    }
}
