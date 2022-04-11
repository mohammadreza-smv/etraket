<?php


namespace Modules\orders\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\cart\Models\ShoppingCart;
use Modules\orders\Repository\OrdersRepositoryInterface;

class ShopController extends Controller
{
    public function order_payment(Request $request,OrdersRepositoryInterface $repository){

        $user_id=$request->user()->id;

        run_action('before_order_payment',[$user_id]);

        $shoppingCart=new ShoppingCart(1);
        $shoppingCart=CompleteData('set_order_payment_data',$shoppingCart);
        $send_order_data=$shoppingCart->getData();

        $res=$repository->add_order($user_id,$send_order_data);
        $gateway=str_replace('-','_',Config()->get('gateway.gateway'));
        $data=run_action($gateway.'_gateway_request',[$res],true,true);
        if(array_key_exists('view',$data) && $data['status']=='ok'){
            return CView($data['view'],$data['params']);
        }
        else if(array_key_exists('header',$data) && $data['status']=='ok'){
            return redirect()->to($data['header']);
        }
        else{
            return redirect()->back()
                ->with('error','خطا در اتصال به درگاه مجددا تلاش نمایید');
        }
    }
}
