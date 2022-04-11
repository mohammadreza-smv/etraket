<?php


namespace Modules\sendingType\Models;


use App\Lib\Jdf;
use Modules\sendingType\Repository\SendingTypeRepositoryInterface;
use Log;
class SendingMethod extends SendingInfo
{
    protected $cartData;

    protected $send_methods;

    protected $city_id;

    protected $jdf;

    public function __construct($catData,$city_id=0)
    {
        $this->jdf=new Jdf();

        $this->city_id=$city_id;

        $this->cartData=$catData;

        $sending_type_repository=app(SendingTypeRepositoryInterface::class);

        $this->send_methods=$sending_type_repository->all();

        parent::__construct();
    }

    public function result(){
        $this->setSendProductMethod();
        return $this->cartData;
    }

    public function setSendProductMethod(){
        $product_with_sending_type=[];
        foreach ($this->cartData['product_with_sending_type'] as $cart_type=>$array){
            foreach ($array as $sending_type=>$array2){
                foreach ($array2 as $key=>$value){
                    if(array_key_exists('product_key',$value)){
                        foreach ($value['product_key'] as $product_key){
                            $sending_method=$this->getProductSendingMethod($cart_type,$product_key);
                            $product_with_sending_type=$this->create_new_sending_type_array($product_with_sending_type,$cart_type,$sending_type,$product_key,$sending_method,$key);
                        }
                    }
                }
            }
        }

        foreach ($this->cartData['cart_types'] as  $key=>$value){
            if(!array_key_exists($key,$product_with_sending_type)){
                $product_with_sending_type[$key]=[];
            }
        }

        $this->cartData['send_methods']=$this->get_all_send_methods();
        $product_with_sending_type=$this->set_sending_price($product_with_sending_type);

        $this->cartData['product_with_sending_type']=$product_with_sending_type;

    }

    public function getProductSendingMethod($cart_type,$product_key){
        $m=null;
        if(array_key_exists($cart_type,$this->cartData['products'])){
            if(array_key_exists($product_key,$this->cartData['products'][$cart_type])){
                $data=$this->cartData['products'][$cart_type][$product_key];
                $product_weight=$data->product->product_weight;
                foreach ($this->send_methods as $method){
                    if($product_weight>= $method->weight1 && $product_weight<$method->weight2){
                        $m=$method->type_key;
                    }
                }
            }
        }
        return $m;
    }

    public function create_new_sending_type_array($array,$cart_type,$sending_type,$product_key,$sending_method,$send_time){
        $sending_order_day=$this->get_sending_order_day($send_time,$sending_method);
        if(array_key_exists($cart_type,$array)){
            $newArray=$array[$cart_type];
            if(array_key_exists($sending_type,$newArray)){
                if(array_key_exists($send_time,$newArray[$sending_type])){
                    $newArray=$newArray[$sending_type][$send_time];
                    if(array_key_exists($sending_method,$newArray)){

                        $new_products_key=$newArray[$sending_method]['product_key'];
                        $new_products_key[]=$product_key;
                        $array[$cart_type][$sending_type][$send_time][$sending_method]['product_key']=$new_products_key;
                    }
                    else{
                        $array[$cart_type][$sending_type][$send_time][$sending_method]=[
                            'product_key'=>[$product_key],
                            'sending_order_day'=>$sending_order_day
                        ];
                    }
                }
                else{
                    $array[$cart_type][$sending_type][$send_time]=[
                        $sending_method=>[
                            'product_key'=>[$product_key],
                            'sending_order_day'=>$sending_order_day
                        ]
                    ];
                }
            }
            else{
                $array[$cart_type][$sending_type]=[
                    $send_time=>[
                        $sending_method=>[
                            'product_key'=>[$product_key],
                            'sending_order_day'=>$sending_order_day
                        ]
                    ]
                ];
            }
        }
        else{
            $array=$array+[
                $cart_type=>[
                    $sending_type=>[
                        $send_time=>[
                            $sending_method=>[
                                'product_key'=>[$product_key],
                                'sending_order_day'=>$sending_order_day
                            ]
                        ]
                    ]
                ]
            ];
        }
        return $array;
    }

    public function set_sending_price($product_with_sending_type){

        $this->cartData['final_sending_price']=[];

        foreach ($product_with_sending_type as $cart_type=>$array){
            foreach ($array as $sending_type=>$array2){
                foreach ($array2 as $key=>$array3){
                    foreach ($array3 as $sending_method=>$value){
                        if(array_key_exists('product_key',$value)){
                            $total_price=0;
                            foreach ($value['product_key'] as $product_key){
                                $total_price+=$this->cartData['products'][$cart_type][$product_key]['price2'];
                            }

                            $price_type=array_key_exists($sending_method,$this->cartData['send_methods']) ? $this->cartData['send_methods'][$sending_method]['price_type'] : 0;

                            $get_sending_info=$this->get_sending_info($sending_method,$total_price);
                            $product_with_sending_type[$cart_type][$sending_type][$key][$sending_method]['sending_price']=$get_sending_info['sending_price'];
                            $product_with_sending_type[$cart_type][$sending_type][$key][$sending_method]['sending_time']=$get_sending_info['sending_time'];
                            $product_with_sending_type[$cart_type][$sending_type][$key][$sending_method]['price_type']=$price_type;

                            if($price_type==0 && $get_sending_info['sending_price']>0){
                                $this->cartData['final_price'][$cart_type][$sending_type]= $this->cartData['final_price'][$cart_type][$sending_type]+$get_sending_info['sending_price'];
                            }

                            $this->set_total_sending_price($cart_type,$sending_type,$get_sending_info['sending_price'],$price_type);
                        }
                    }
                }
            }
        }

        return $product_with_sending_type;
    }

    public function get_all_send_methods(){
        $array=array();
        foreach ($this->send_methods as $method){
            $array[$method->type_key]=[
                'title'=>$method->type_name,
                'icon'=>$method->type_icon,
                'price_type'=>$method->price_type,
                'send_type_name'=>$method->send_type_name,
            ];
        }
        return $array;
    }

    public function get_sending_order_day($send_time,$sending_method){

        if(array_key_exists($sending_method.'_send_time',$this->sending_options)){
            $send_time=$send_time+intval($this->sending_options[$sending_method.'_send_time']);
        }

        $day1=$send_time;
        $day2=$day1+3;

        $minTimeStamp=strtotime('+ '.$day1.'day');
        $maxTimeStamp=strtotime('+ '.$day2.'day');

        $day_label1=$this->jdf->jdate('j F',$minTimeStamp);
        $day_label2=$this->jdf->jdate('j F',$maxTimeStamp);

        return [
            'day_label1'=>$day_label1,
            'day_label2'=>$day_label2
        ];
    }

    protected function set_total_sending_price($cart_type,$sending_type,$sending_price,$price_type)
    {
        if(array_key_exists($cart_type,$this->cartData['final_sending_price'])){
            if(array_key_exists($sending_type,$this->cartData['final_sending_price'][$cart_type])){

                $old_price=$this->cartData['final_sending_price'][$cart_type][$sending_type]['price'];

                $sending_price=$old_price+$sending_price;

            }
        }
        $this->add_final_sending_price($cart_type,$price_type,$sending_type,$sending_price);
    }

    public function add_final_sending_price($cart_type,$price_type,$sending_type,$sending_price){
        if($price_type==0){
            $this->cartData['final_sending_price'][$cart_type][$sending_type]['price']=$sending_price;
        }
        else{
            $this->cartData['final_sending_price'][$cart_type][$sending_type]['price']=0;
            $this->cartData['final_sending_price'][$cart_type][$sending_type]['after_price']=true;
        }
    }
}
