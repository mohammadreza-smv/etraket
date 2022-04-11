<?php


namespace Modules\api;

use App\BaseModule;
use Session;
class Module extends BaseModule
{
    protected $discount_code=null;
    protected $discount_value=0;

    public function before_api_add_order(){

        $request=request();
        $code=$request->get('discountCode',null);

        $address_id=$request->get('address_id');

        $send_type=$request->get('send_type');
        $send_type=($send_type=="1") ? "normal" : "fast";

        define('send_type',$send_type);
        define('address_id',$address_id);

        if(!Session::has('discount_value') && $code && class_exists(\Modules\discount\Models\DiscountCode::class)){

            $discountCode=new \Modules\discount\Models\DiscountCode($code);
            $result=$discountCode->check();
            if(is_array($result) && array_key_exists('status',$result) && $result['status']=='ok'){

                $this->discount_value=$result['discount_value'];
                $this->discount_code=$code;
            }
        }

    }
    public function checkout_final_price($data){

        if($this->discount_value>0){
            if(array_key_exists("normal",$data[1])){
                $data[1]['normal']= ($data[1]['normal'] - intval($this->discount_value));
            }
            if(array_key_exists("fast",$data[1])){
                $data[1]['fast']= ($data[1]['fast'] - intval($this->discount_value));
            }
        }
        return $data;
    }

    public function set_order_detail($detail){
        if($this->discount_code && $this->discount_value>0){
            $detail['discount_value']=$this->discount_value;
            $detail['discount_code']=$this->discount_code;
        }
        return $detail;
    }
}
