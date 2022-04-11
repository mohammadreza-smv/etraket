<?php
namespace App\Http\Controllers\api;
use App\AdditionalInfo;
use App\Address;
use App\Cart;
use App\DiscountCode;
use App\GiftCart;
use App\Http\Controllers\Controller;
use App\Lib\Mellat_Bank;
use App\Lib\ZarinPal;
use App\Order;
use App\OrderData;
use App\OrderingTime;
use Illuminate\Http\Request;
use DB;
class UserController extends Controller{
    public function checkOrderRegisterCondition(Request $request){
        $user_id=$request->user()->id;
        $info_row=AdditionalInfo::where('user_id',$user_id)->count();
        if($info_row==0){
            return 'add_user_info';
        }
        else{
            $address=Address::where('user_id',$user_id)->orderBy('id','DESC')->first();
            if(!$address){
                return 'add_address';
            }
            else{
                return  $address->id;
            }
        }
    }
    public function get_total_data($city_id,Request $request){
        $user_id=$request->user()->id;
        $address=Address::where(['user_id'=>$user_id,'id'=>$city_id])
            ->orderBy('id','DESC')->first();
        if($address){
            $province=$address->getProvince;
            $getCity=$address->getCity;
            $OrderingTime=new OrderingTime($address->city_id);
            $send_order_data=$OrderingTime->getGlobalSendData();
            return  [
                'send_order_data'=>$send_order_data,
                'username'=>$address->name,
                'province'=>$province,
                'city'=>$getCity,
                'status'=>'ok'
            ];
        }
        else{
            return [
                'status'=>'error'
            ];
        }
    }
    public function addInfo(Request $request){
        $user_id=$request->user()->id;
        $additionalInfo=new AdditionalInfo($request->all());
        $additionalInfo->user_id=$user_id;
        if($additionalInfo->save()){
            $name=$additionalInfo->first_name.' '.$additionalInfo->last_name;
            User::where('id',$user_id)->update(['name'=>$name]);
            return 'ok';
        }
        else{
            return  'error';
        }
    }
    public function addAddress(Request $request){
        $user_id=$request->user()->id;
        $address=new Address($request->all());
        if($request->get('userOrder')=="true"){
            $address->name=$request->user()->name;
            $address->mobile=$request->user()->mobile;
        }
        $address->user_id=$user_id;
        $address->save();
        return 'ok';
    }
    public function update_address(Request $request,$address_id){
        $user_id=$request->user()->id;
        $address=Address::where([
            'id'=>$address_id,
            'user_id'=>$user_id
        ])->firstOrFail();
        if($request->get('userOrder')=="true"){
            $address->name=$request->user()->name;
            $address->mobile=$request->user()->mobile;
        }
        $address->update($request->all());
        return 'ok';
    }
    public function remove_address(Request $request){
        $user_id=$request->user()->id;
        $address_id=$request->get('id');
        $address=Address::where([
            'id'=>$address_id,
            'user_id'=>$user_id
        ])->firstOrFail();
        $address->delete();
        return 'ok';
    }
    public function changeProductCountOfCartTable(Request $request){
        $productWarrantyId=$request->get('productWarrantyId');
        $userId=$request->user()->id;
        return changeProductCountOfCartTable('reduction',$productWarrantyId,$userId);
    }
    public function removeProductOfCartTable(Request $request){
        $productWarrantyId=$request->get('productWarrantyId');
        $userId=$request->user()->id;
        $res=DB::table('cart')->where(['user_id'=>$userId,'product_warranty_id'=>$productWarrantyId])->delete();
        if($res){
            return 'ok';
        }
        else{
            return  'error';
        }
    }
    public function updateCartTableData(Request $request){
        Cart::refresh_cart_table();
        return 'ok';
    }
    public function checkGiftCart(Request $request){
        $code=$request->get('code');
        $cart_final_price=intval($request->get('orderPrice'));
        return check_gift_cart_for_app($request,$code,$cart_final_price);
    }
    public function check_discount_code(Request $request){
        $code=$request->get('code');
        return check_discount_code($code);
    }
    public function add_order(Request $request){
        $address_id=$request->get('address_id');
        $send_type=$request->get('send_type');
        $giftCart=$request->get('giftCart',0);
        $discountCode=$request->get('discountCode',0);
        $user_id=$request->user()->id;
        $address=Address::where(['id'=>$address_id,'user_id'=>$user_id])->first();
        $OrderingTime=new OrderingTime($address->city_id);
        $send_order_data=$OrderingTime->getGlobalSendData();

        $data=[
            'address_id'=>$address_id,
            'send_type'=>$send_type
        ];

        $orderFinalPrice=($send_type==1) ? $send_order_data['integer_normal_cart_price'] : $send_order_data['integer_fasted_cart_amount'];

        if($giftCart){
            $gift_cart_res=check_gift_cart_for_app($request,$giftCart,$orderFinalPrice);
            if(is_array($gift_cart_res) && $gift_cart_res['status']=="ok"){
                $data['gift_value']=$gift_cart_res['gift_value'];
                $data['gift_cart']=$gift_cart_res['gift_id'];
                $orderFinalPrice=$orderFinalPrice-$gift_cart_res['gift_value'];
            }
        }

        if($discountCode){
            $discount_code_res=check_discount_code($discountCode);
            if(is_array($discount_code_res) && $discount_code_res['status']=="ok"){
                $data['discount_code']=$discountCode;
                $data['discount_value']=$discount_code_res['discount_value'];
                $orderFinalPrice=$orderFinalPrice-$data['discount_value'];
            }
        }

        $data['total_price']=$orderFinalPrice;
        $order=new Order();
        $result=$order->add_order($send_order_data,false,$data);
        if($result['status']=='ok'){
            $url=url('api/order/payment/'.$result['order_id']);
            return [
                'status'=>'ok',
                'redirect_url'=>$url
            ];
        }
        else{
            return [
                'status'=>'error'
            ];
        }
    }
    public function payment($order_id){
        $order=Order::where(['id'=>$order_id,'pay_status'=>'awaiting_payemnt'])->first();
        if($order){
            $data['price']=$order->price;
            $data['order_id']=$order_id;
            $url=url('api/order/verify');
            return Order::Gateway($data,$url);
        }
        else{
            echo 'اجرای درخواست شما امکانپذیر نمی باشد';
        }
    }
    public function verify(Request $request){

        $RefId=$request->get('RefId');
        $ResCode=$request->get('ResCode');
        $SaleOrderId=$request->get('SaleOrderId');
        $SaleReferenceId=$request->get('SaleReferenceId');
        if($ResCode==0 && $request->has('ResCode'))
        {
            $order=Order::with(['getProductRow.getProduct','getOrderInfo'])
                ->where(['pay_code1'=>$RefId,'pay_status'=>'awaiting_payemnt'])->firstOrFail();
            require  '../app/Lib/nusoap.php';

            $mellat_bank=new Mellat_Bank();
            if($mellat_bank->Verify($SaleOrderId,$SaleReferenceId)){
                Cart::empty_cart($order->user_id);
                return Order::changeOrderStatus($order,$SaleReferenceId,false);
            }
            else{
               return  view('app.verify',['error_payment'=>'پرداخت انجام نشده ، در صورتی که پول از حسابتان کسر شده باشد تا ۱۵ دقیقه دیگه به حسابتان برگشت داده خواهد شد']);
            }
        }
        elseif($request->has('Authority')){
            $Authority=$request->get('Authority');
            $order=Order::with(['getProductRow.getProduct','getOrderInfo'])
                ->where(['pay_code1'=>$Authority,'pay_status'=>'awaiting_payemnt'])->firstOrFail();
            $zarinpal=new ZarinPal();
            $refId=$zarinpal->verify($order->price,$Authority);
            if($refId){
                Cart::empty_cart($order->user_id);
                return Order::changeOrderStatus($order,$refId);
            }
            else{
                return  view('app.verify',['error_payment'=>'پرداخت انجام نشده ، در صورتی که پول از حسابتان کسر شده باشد تا ۱۵ دقیقه دیگه به حسابتان برگشت داده خواهد شد']);
            }
        }
        else{
            return  view('app.verify',['error_payment'=>'درخواست شما معتبر نمی باشد']);
        }
    }
    public function address_list(Request $request){
      //  sleep(3);
        $user_id=$request->user()->id;
        $userAddress=Address::with(['getProvince','getCity'])
            ->where('user_id',$user_id)
            ->orderBy('id','DESC')
            ->paginate(10);
        return $userAddress;
    }
}
