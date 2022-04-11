<?php


namespace Modules\discount\Models;
use Modules\cart\Models\ShoppingCart;
use Auth;
use Session;
class DiscountCode
{
    protected $code;

    protected $discounts;

    protected $products=[];

    protected $discount_products=[];

    protected $variation=[];

    public function __construct($code)
    {
        $this->code=$code;

        $this->getDiscount();
    }

    protected function getDiscount(){
        $time=time();
        $this->discounts=Discount::where('code',$this->code)
            ->where('expiry_time','>=',$time)->orderBy('amount','DESC')->get();
        $user=\Auth::check() ? \Auth::user()->id : 0;
        if(sizeof( $this->discounts)>0){
            Session::put('discount_id',$this->discounts[0]['id']);
        }


        $used=false;
        foreach ($this->discounts as $value){
            $key='user_'.\Auth::user()->id.'_discount'.$value->id;
            $number_usable=cache()->get($key);
            if($number_usable){
                if($number_usable>=$value->number_usable){
                    $used=true;
                }
            }
        }
        if($used){
            $this->discounts=[];
        }

    }

    public function check(){
        $discount_value=0;
        if(sizeof( $this->discounts)>0){
            $this->set_product_data();
            $i=0;
            foreach ($this->discounts as $discount){
                $this->discount_products[$i]=[];
                foreach ($this->products as $product){
                    $check_has_discount=run_action('check_has_discount',[$discount,$product],true);
                    $this->addProduct($i,$check_has_discount,$discount,$product);
                }
                $i++;
            }
            foreach ($this->discounts as $key=>$value){
                $price=0;
                if(array_key_exists($key,$this->discount_products)){
                    foreach ($this->discount_products[$key] as $variation_id=>$product_price){
                        $price+=$product_price;
                    }
                }
                if($price>$value->amount){
                    if(!empty($value->amount_discount)){
                        $amount_discount=intval($value->amount_discount);

                        $discount_value+=$amount_discount;
                    }
                    else if(!empty($value->amount_percent)){
                        $percent=intval($value->amount_percent);
                        $discount_value+=(($percent*$price)/100);
                    }

                }
            }

           return  [
               'discount_value'=>$discount_value,
               'code'=>$this->code,
               'status'=>'ok'
           ];
        }
        else{
            return [
                'status'=>'error',
                'message'=>'کد تخفیف وارد شده اشتباه می باشد'
            ];
        }
    }

    protected function set_product_data(){
        $shoppingCart=new ShoppingCart(1);
        $cart_data=$shoppingCart->getData(true);
        if(is_array($cart_data) && array_key_exists('products',$cart_data)){
            $this->products=$cart_data['products'][1];
        }
    }

    protected function addProduct($key,$check_has_discount,$discount,$product){
        $add=true;
        $i=1;
        if(is_array($check_has_discount)){

            foreach ($check_has_discount as $result){
                if($result===false){
                    $add=false;
                }

                if($result==true){
                    $i++;
                }
            }
        }
        if($add){
           if(array_key_exists($product->id,$this->variation)){
               if($i> $this->variation[$product->id]){
                   $this->variation[$product->id]=$i;
                   $this->remove_product_discount($product);
                   $this->add_product_discount($key,$product);
               }
           }
           else{
               $this->variation[$product->id]=$i;
               $this->add_product_discount($key,$product);
           }
        }

    }

    protected function add_product_discount($key,$product){
       $products=$this->discount_products[$key];
       $this->discount_products[$key]=$products+[$product->id=>$product->price2];
    }

    protected function remove_product_discount($variation){
        foreach ($this->discount_products as $index=>$row){
            if(array_key_exists($variation->id,$row)){
                unset($this->discount_products[$index][$variation->id]);
            }
        }
    }
}
