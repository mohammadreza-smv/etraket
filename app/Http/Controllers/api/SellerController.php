<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Seller;
use App\Category;
use App\Brand;
use App\Color;
use App\Message;
use App\Product;
use DB;
use Validator;
use App\Order;
use Illuminate\Contracts\Encryption\DecryptException;
use App\OrderProduct;
use App\Payment;
use Crypt;
class SellerController extends Controller
{
    public function total_product(Request $request)
    {
        $search_text=$request->get('search_text');
        $seller_id=$request->user()->id;
        $Product=Product::orderBy('id','DESC');
        if(!empty($search_text))
        {
            $Product=$Product->where('title','like','%'.$search_text.'%');
        }
        $Product=$Product->select(['id','title','image_url','price','discount_price','status','cat_id'])
        ->where('seller_id','!=',$seller_id)
        ->whereIn('status',[0,1])
        ->withCount('sellerList')
        ->withCount('getWarranty')
        ->with('DigiWarranty')
        ->paginate(5);
        return   $Product;
    }
    public function get_sale_report(Request $request)
    {
        $seller_id=$request->user()->id;
        $jdf=new \App\Lib\Jdf();
        $y=$jdf->tr_num($jdf->jdate('Y'));
        $y=!empty($request->get('default_year')) ?  $request->get('default_year') : $y;
        $now=$jdf->tr_num($jdf->jdate('Y'));

        $totalSale=DB::table('seller_sale_statistics')->where('seller_id',$seller_id)->sum('price');
        $commission=DB::table('seller_sale_statistics')->where('seller_id',$seller_id)->sum('commision');
        $data=get_sale_report($request,$y,'seller_sale_statistics',['year'=>$y,'seller_id'=>$seller_id],'price',$now);
        $data['totalSale']=$totalSale;
        $data['commission']=$commission;
        return $data;
    }
    public function orders(Request $request)
    {
        return OrderProduct::getSellerOrders($request);
    }
    public function read_order(Request $request,$id)
    {
        $seller_id=$request->user()->id;
        $order=OrderProduct::where(['seller_id'=>$seller_id,'order_id'=>$id,'seller_read'=>'no'])->first();
        if($order)
        {
            $order->seller_read='ok';
            $order->update();
            return 'ok';
        }
        else{
            return 'error';
        }
    }
    public function payemnt(Request $request)
    {
        $seller_id = $request->user()->id;
        $payment=Payment::where('seller_id', $seller_id)->orderBy('id','DESC');
        $date = $request->get('date');
        if (!empty($date)) {
            $first = getTimestamp($date, 'first');
            $last = getTimestamp($date, 'last');
            $payment = $payment->whereBetween('time', [$first, $last]);
        }
        return  $payment->paginate(10);
    }
    public function getMessageList(Request $request)
    {
        $seller_id = $request->user()->id;
        $title=$request->get('title');
        $message =Message::orderBy('id', 'DESC')->with(['from', 'to']);
        $message = $message->where(['user_id' => $seller_id, 'user_type' => 'App\Seller', 'parent_id' => 0]);
        if (!empty($title)) {
            $message = $message->where('title', 'like', '%' .  $title . '%');
        }
        $message = $message->paginate(10);
        return $message;
    }
    public function addMessage(Request $request)
    {
        return Seller::addMessage($request);
    }
    public function getMessageContent($id, Request $request)
    {
        $seller_id = $request->user()->id;
        $message=Message::with('getAnswer')->where(['id'=>$id,'user_id'=>$seller_id,'user_type'=>'App\Seller'])->first();
        if($message){
            $message->status=0;
            $message->update();
            return $message;
        }
        else{
            return 'redirect';
        }
    }
    public function addAnswer($id,Request $request)
    {
        return Seller::addAnswer($id,$request);
    }
}
