<?php


namespace Modules\cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\cart\Models\Cart;
use Modules\cart\Models\ShoppingCart;
use Session;
class ShoppingController extends Controller
{

    public function shipping(){

        run_action('before_shipping_method',[]);

        return CView('cart::'.$this->view.'shipping.set_data');

    }

    public function getCartData($city_id,Request $request){
        $shoppingCart=new ShoppingCart(1);
        $shoppingCart->city_id=$city_id;
        $cart_data=$shoppingCart->getData();
        return $cart_data;
    }

    public function payment(Request $request){
        if(Cart::get_product_count()>0){
            $user_id=$request->user()->id;
            run_action('before_payment_method',[$user_id,$request]);

            $send_type=$request->get('send_type','normal');

            Session::put('order_send_type',$send_type);

            $shoppingCart=new ShoppingCart(1);
            $shoppingCart=CompleteData('set_order_payment_data',$shoppingCart);
            $send_order_data=$shoppingCart->getData();

            return CView('cart::'.$this->view.'shipping.payment',compact('send_order_data','send_type'));

        }
        else
        {
            return redirect('/');
        }
    }

    public function verify(Request $request){

        $detail=run_action('order_verify',[
            [
                'view'=>$this->view
            ]
        ],true,true);

        if(array_key_exists('status',$detail)){
            if($detail['status']=='ok'){
                Cart::empty_cart();
                run_action('after_payment',[$detail]);
            }
        }

        if(array_key_exists('order',$detail)){
            return CView('cart::'.$this->view.'.shipping.verify',compact('detail'));
        }
        else{
            return  redirect('/');
        }
    }
}
