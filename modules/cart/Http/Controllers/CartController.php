<?php


namespace Modules\cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Modules\cart\Models\Cart;
use Modules\cart\Models\ShoppingCart;
use Modules\cart\Repository\CartRepositoryInterface;

class CartController extends Controller
{
    public function add_cart(Request $request): array
    {
        run_action('card_changed',[]);
        $cart=new Cart();
        $cart->add_cart($request->all());
        return [
            'status'=>'ok'
        ];
    }

    public function show_cart(){
        $shoppingCart=new ShoppingCart();
        $cart_data=$shoppingCart->getData();
        return CView('cart::'.$this->view.'cart_products',['cart_data'=>$cart_data]);
    }

    public function remove_product(Request $request){
        run_action('card_changed',[]);
        $cart=new Cart();
        $result=$cart->remove_product($request);
        if($result=='ok'){
            $shoppingCart=new ShoppingCart();
            return $shoppingCart->getData();
        }
        else{
            return  $result;
        }
    }

    public function change_product_cart(Request $request)
    {
        run_action('card_changed',[]);
        $cart=new Cart();
        $cart->change_product_cart($request);
        $shoppingCart=new ShoppingCart();
        return $shoppingCart->getData();
    }

    public function change_cart_product_type(Request $request,CartRepositoryInterface $cartRepository){

        $price_variation_id=$request->get('price_variation_id');
        $type=$request->get('type');
        $where_type=$request->get('where_type');
        $price_variation_id=explode(',',$price_variation_id);
        if(Auth::check()){
            $result=$cartRepository->change_cart_product_type($price_variation_id,$type,$where_type);
            if($result=='ok'){
                return  $result;
            }
            else{
                $shoppingCart=new ShoppingCart();
                return $shoppingCart->getData();
            }
        }
        else{
            return abort(401);
        }
    }

    public function cartProductData(Request $request){
        $shoppingCart=new ShoppingCart(1);
        $cart_data=$shoppingCart->getData();
        return $cart_data;
    }
}
