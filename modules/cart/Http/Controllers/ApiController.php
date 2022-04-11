<?php


namespace Modules\cart\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Modules\cart\Models\Cart;
use Modules\cart\Models\CartTable;
use Modules\cart\Models\ShoppingCart;

class ApiController extends Controller
{
    public function getCartData(Request $request){

        $cart=$request->get('cartData');
        $cart=getApplicationCartProducts($cart);
        if($request->header('Authorization')) {
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $user_id=$user->id;

                $cartTable=new CartTable();
                $cartTable->add_session_cart_to_table($user,$cart);
            }
        }
        $shoppingCart=new ShoppingCart(1,$cart);
        $cart_data=$shoppingCart->getData();
        return $cart_data;
    }

    public function remove_product(Request $request){
        $cart=new Cart();
        $result=$cart->remove_product($request);
        return $result;
    }

    public function update_cart_table(Request $request){
        Cart::refresh_cart_table();
    }

    public function change_product_count_of_table(Request $request){

        $cart=new Cart();
        $cart->change_product_cart($request);
        return 'ok';
    }
}
