<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderData;
use App\OrderInfo;
use Illuminate\Http\Request;
use DB;
use App\Stockroom;
use App\OrderProduct;
use Auth;
class OrdersController extends CustomController
{
    public function show($order_id)
    {
        $order_discount=DB::table('order_discount')->where('order_id',$order->id)->get();

        return view('orders.show',['order'=>$order,'order_data'=>$order_data,'order_discount'=>$order_discount]);
    }
    public function submission(Request $request)
    {
        $submission=OrderInfo::getData($request->all(),0,'DESC');
        return view('orders.submission',[
            'label'=>'مدیریت مرسوله ها' ,
            'label_url'=>'submission',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function submission_info($id){

        $submission_info=OrderInfo::with(['getOrder.getAddress','getEvent.getUser'])->has('getOrder')->where('id',$id)->firstOrFail();
        $order_data=new OrderData($submission_info->getOrder->getOrderInfo,$submission_info->getOrder->getProductRow,$submission_info->getOrder->user_id);
        $order_data=$order_data->getData($id);
        return view('orders.submission_info',['submission_info'=>$submission_info,'order_data'=>$order_data]);
    }
    public function submission_approved(Request $request){
        $submission=OrderInfo::getData($request->all(),1);
        return view('orders.submission',[
            'label'=>'مرسوله های تایید شده' ,
            'label_url'=>'submission/approved',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function items_today(Request $request){
        $submission=OrderInfo::getData($request->all(),2);
        return view('orders.submission',[
            'label'=>'مرسوله های ارسالی امروز' ,
            'label_url'=>'submission/items/today',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function submission_ready(Request $request){
        $submission=OrderInfo::getData($request->all(),3);
        return view('orders.submission',[
            'label'=>'مرسوله های آماده ارسال' ,
            'label_url'=>'submission/ready',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function posting_send(Request $request){
        $submission=OrderInfo::getData($request->all(),4);
        return view('orders.submission',[
            'label'=>'مرسوله های ارسال شده به پست' ,
            'label_url'=>'posting/send',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function posting_receive(Request $request){
        $submission=OrderInfo::getData($request->all(),5);
        return view('orders.submission',[
            'label'=>'مرسوله های آماده دریافت از پست' ,
            'label_url'=>'posting/receive',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function delivered_shipping(Request $request){
        $submission=OrderInfo::getData($request->all(),6);
        return view('orders.submission',[
            'label'=>'مرسوله های تحویل داده شده' ,
            'label_url'=>'delivered/shipping',
            'submission'=>$submission,
            'req'=>$request
        ]);
    }
    public function submission_foctor($submission_id)
    {
        $submission_info=OrderInfo::with('getOrder.getAddress')->has('getOrder')->where('id',$submission_id)->firstOrFail();
        $order_data=new OrderData($submission_info->getOrder->getOrderInfo,$submission_info->getOrder->getProductRow,$submission_info->getOrder->user_id);
        $order_data=$order_data->getData($submission_id);
        $order_discount=DB::table('order_discount')->where('order_id',$submission_info->order_id)->get();

        return view('orders.factor',['submission_info'=>$submission_info,'order_data'=>$order_data,'order_discount'=>$order_discount]);
    }
    public function return_product($id)
    {
        $stockroom=['0'=>'انتخاب انبار']+Stockroom::pluck('name','id')->toArray();
        $orderProduct=OrderProduct::with(['getProduct','getColor','getWarranty','getSeller','getOrder'])
        ->whereHas('getOrder')->where(['send_status'=>6,'id'=>$id])->firstOrFail();
        return view('orders.return_product',['stockroom'=>$stockroom,'orderProduct'=>$orderProduct]);
    }
    public function add_return_product($id,Request $request)
    {
        $orderProduct=OrderProduct::with(['getProduct'])
        ->whereHas('getOrder')->where(['send_status'=>6,'id'=>$id])->firstOrFail();
        $count=$request->get('count',1);
        $result=OrderProduct::setReturnProduct($count,$request,$orderProduct);
        if($result=='ok')
        {
            $message='ثبت درخواست با موفقیت انجام شد';
            $name='message';
        }
        else
        {
            $message='خطا در ثبت اطلاعات مجددا تلاش نمایید';
            $name='warring';
        }
        return redirect('admin/orders/return-product')->with($name,$message);
    }
    public function return_product_list(Request $request)
    {
        $return_product_list=OrderProduct::getList($request->all());
        return view('orders.return_product_list',['return_product_list'=>$return_product_list,'req'=>$request]);
    }
    public function remove_return_product(Request $request)
    {
        $id=$request->get('id');
        $orderProduct=OrderProduct::with(['getProduct'])
        ->whereHas('getOrder')->where(['send_status'=>-1,'id'=>$id])->firstOrFail();
        $result=OrderProduct::RemoveReturnProduct($request,$orderProduct);
        if($result=='ok')
        {
            $message='ثبت درخواست با موفقیت انجام شد';
            $name='message';
        }
        else
        {
            $message='خطا در ثبت اطلاعات مجددا تلاش نمایید';
            $name='warring';
        }
        return redirect('admin/orders/return-product')->with($name,$message);
    }
}
