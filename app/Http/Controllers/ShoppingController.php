<?php

namespace App\Http\Controllers;

use App\Address;
use App\Cart;
use App\DiscountCode;
use App\GiftCart;
use App\Lib\Mellat_Bank;
use App\Lib\Mobile_Detect;
use App\Lib\ZarinPal;
use App\Order;
use App\OrderData;
use App\OrderingTime;
use App\Province;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Jobs\OrderStatistics;
use Mail;
use URL;
use Auth;
class ShoppingController extends Controller
{
    public function shipping(Request $request)
    {
        if(Cart::get_product_count()>0)
        {
            $user_id=$request->user()->id;
            $address=Address::with(['getProvince','getCity'])->where('user_id',$user_id)
                ->orderBy('id','DESC')->get();
            return view($this->view.'shipping.set_data',['address'=>$address]);
        }
        else{
            return redirect('/');
        }
    }
    public function order_payment(Request $request)
    {
        $address_id=Session::get('order_address_id');
        $user_id=$request->user()->id;
        if($address_id)
        {
            $address=Address::where(['id'=>$address_id,'user_id'=>$user_id])->first();
            if($address){
                $OrderingTime=new OrderingTime($address->city_id);
                $send_order_data=$OrderingTime->getGlobalSendData();
                $order=new Order();
                $result=$order->add_order($send_order_data);
                if($result['status']=='ok'){
                    if($result['price']==0)
                    {
                        return  redirect('/order/verify/'.$result['order_id']);
                    }
                    else{
                        return Order::Gateway($result);
                    }
                }
                else{
                    return  redirect()->back();
                }
            }
            else{
                return redirect('/shipping');
            }
        }
        else{
            return redirect('/shipping');
        }

    }
    public function verify(Request $request){
        $RefId=$request->get('RefId');
        $ResCode=$request->get('ResCode');
        $SaleOrderId=$request->get('SaleOrderId');
        $SaleReferenceId=$request->get('SaleReferenceId');
        if($ResCode==0 && $request->has('ResCode'))
        {
            $order=Order::with(['getProductRow.getProduct','getOrderInfo','getAddress','getGiftCart','getUserInfo'])
                ->where(['pay_code1'=>$RefId])->firstOrFail();
            require  '../app/Lib/nusoap.php';
            $mellat_bank=new Mellat_Bank();
            if($mellat_bank->Verify($SaleOrderId,$SaleReferenceId)){
                Cart::empty_cart();
                return Order::changeOrderStatus($order,$SaleReferenceId);
            }
            else{
                Cart::empty_cart();
                $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id,'ok');
                $order_data=$order_data->getData();
                return view('shipping.verify',['order'=>$order,'order_data'=>$order_data,'error_payment'=>'پرداخت انجام نشده ، در صورتی که پول از حسابتان کسر شده باشد تا ۱۵ دقیقه دیگه به حسابتان برگشت داده خواهد شد ']);
            }
        }
        elseif($request->has('Authority')){
            $Authority=$request->get('Authority');
            $order=Order::with(['getProductRow.getProduct','getOrderInfo','getAddress','getGiftCart','getUserInfo'])
                ->where(['pay_code1'=>$Authority])->firstOrFail();
            $zarinpal=new ZarinPal();
            $refId=$zarinpal->verify($order->price,$Authority);
            Cart::empty_cart();
            if($refId){
                return Order::changeOrderStatus($order,$refId);
            }
            else{
                $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id,'ok');
                $order_data=$order_data->getData();
                return view('shipping.verify',['order'=>$order,'order_data'=>$order_data,'error_payment'=>'پرداخت انجام نشده ، در صورتی که پول از حسابتان کسر شده باشد تا ۱۵ دقیقه دیگه به حسابتان برگشت داده خواهد شد ']);
            }
        }
        else{
            return  redirect('/');
        }
    }


    public function verify2()
    {
        $order_id=51;
        DB::beginTransaction();
        try{
            $order=Order::with(['getProductRow.getProduct','getOrderInfo','getAddress','getGiftCart','getUserInfo'])
                ->where(['id'=>$order_id])->firstOrFail();
            $order->pay_status='ok';
            $order->update();

            $order_data=new OrderData($order->getOrderInfo,$order->getProductRow,$order->user_id,'ok');
            $order_data=$order_data->getData();

            if(Session::has('gift_value') && Session::get('gift_value')>0){
                $gift_value=Session::get('gift_value');
                $gift_id=Session::get('gift_cart');
                $giftCart=GiftCart::where('id',$gift_id)->first();
                if($giftCart){
                    $giftCart->credit_used=$giftCart->credit_used+$gift_value;
                    $giftCart->update();
                }

                Session::forget('gift_value');
                Session::forget('gift_cart');
            }

            DB::table('order_infos')->where('order_id',$order_id)->update(['send_status'=>1]);
            DB::table('order_products')->where('order_id',$order_id)->update(['send_status'=>1]);

            DB::commit();
            OrderStatistics::dispatch($order);

            set_sale($order);
            // if(!empty($order->getUserInfo->email))
            // {
            //     Mail::to($order->getUserInfo->email)->queue(new \App\Mail\Order($order,$order_data));
            // }

            return view('shipping.verify',['order'=>$order,'order_data'=>$order_data]);

        }
        catch (\Exception $exception){
            return view('shipping.verify',['order'=>$order,'order_data'=>$order_data,'error_payment'=>'خطا در ثبت اطلاهات،لطفا برای بررسی خطا پیش آمده با پشتیبانی فروشگاه در ارتباط باشید']);
        }

    }
    public function check_gift_cart(Request $request){
        $code=$request->get('code');
        $gift_cart=GiftCart::where('code',$code)->first();
        if($gift_cart){
            $cart_final_price=Session::get('cart_final_price',0);
            if(Session::get('gift_value',0)>0){
                $cart_final_price=$cart_final_price+Session::get('gift_value',0);
            }
            if($gift_cart->credit_cart-$gift_cart->credit_used>0)
            {
                $use=$gift_cart->credit_cart-$gift_cart->credit_used;
                if($cart_final_price<$use){
                    $use=$cart_final_price;
                }
                Session::put('gift_value',$use);
                Session::put('gift_cart',$gift_cart->id);
                $cart_final_price=$cart_final_price-$use;
                return [
                    'status'=>'ok',
                    'gift_value'=>replace_number(number_format($use)).' تومان',
                    'cart_final_price'=>replace_number(number_format($cart_final_price)).' تومان'
                ];
            }
            else
            {
                return 'اعتبار کارت هدیه برای استفاده به اتمام رسیده';
            }
        }
        else{
            return 'کارت هدیه وارد شده اشتباه می باشد';
        }
    }
    public function check_discount_code(Request $request)
    {
        $code=$request->get('code');
        $time=time();
        $discounts=DiscountCode::where('code',$code)->where('expiry_time','>=',$time)->get();
        if($discounts){
            return DiscountCode::check($discounts);
        }
        else
        {
            return 'کد تخفیف وارد شده اشتباه می باشد';
        }
    }
    public function getSendData($city_id)
    {
        $OrderingTime=new OrderingTime($city_id);
        return $OrderingTime->getGlobalSendData();
    }
}
