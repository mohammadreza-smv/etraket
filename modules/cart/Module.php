<?php


namespace Modules\cart;

use App\BaseModule;
use Modules\cart\Models\Cart;
use Modules\cart\Models\CartTable;
use DB;
use URL;
use Session;
class Module extends BaseModule
{
    public function authenticated($user){
       $cartTable=new CartTable();
       $cartTable->add_session_cart_to_table($user);
    }

    public function product_price_variation_updated($model){
        $update=[];
        if($model->price2!=$model->getOriginal('price2')){
            $update['final_amount']=$model->price2;
        }
        if($model->product_number!=$model->getOriginal('product_number')){
            if($model->product_number==0){
                $update['product_status']='unavailable';
            }
            else if($model->getOriginal('product_number')==0){
                $update['product_status']='available';
            }
        }
        if(sizeof($update)>0){
            DB::table('cart')->where([
                'price_variation_id'=>$model->id
            ])->update($update);
        }
    }

    public function before_shipping_method(){
        if(Cart::get_product_count()==0 || !Session::has('final_price'))
        {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect('/Cart'));
        }
        $previous_url=URL::previous();
        if($previous_url==url('Cart')){
            Cart::refresh_cart_table();
        }

    }

    public function after_complete_cart_data($data){
        if(array_key_exists('final_price',$data)){
            if(array_key_exists(1,$data['final_price'])){
                Session::put('final_price',$data['final_price'][1]['normal']);
                Session::put('cart_price',$data['cart_price'][1]);
                Session::put('total_price',$data['total_price'][1]);
                Session::put('product_count',sizeof($data['products'][1]));
            }
        }
    }

    public function registerComponent($theme,$type){
        if(!request()->is('admin/*')){
            return vue_component_detail('cart');
        }
    }

    public function product_price_variation_deleted($model){
        DB::table('cart')->where('price_variation_id',$model->id)->delete();
    }
}
