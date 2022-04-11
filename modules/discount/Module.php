<?php


namespace Modules\discount;

use App\BaseModule;
use Modules\categories\Models\Category;
use Session;

class Module extends BaseModule
{
    protected $parent_cat=[];

    public function discount_create_form(){
        if(class_exists(Category::class)){
            $cats=Category::catList();
            view()->share('cats',$cats);
            return [
                'after_expiry_time'=>'discount::cat-list',
            ];
        }
    }

    public function discount_edit_form(){
        if(class_exists(Category::class)){
            $cats=Category::catList();
            view()->share('cats',$cats);
            return [
                'after_expiry_time'=>'discount::cat-list',
            ];
        }
    }

    public function check_has_discount($discount,$variation){
        if($discount->cat_id>0){
            $cat_id=$discount->cat_id;
            if(!array_key_exists($cat_id,$this->parent_cat)){
                $parent=Category::where('parent_id',$discount->cat_id)->pluck('id','id')->toArray();
                $parent[$cat_id]=$cat_id;
                $this->parent_cat[$cat_id]=$parent;
            }
            if(array_key_exists($variation->product->cat_id,$this->parent_cat[$cat_id])){
                return  true;
            }
            else{
                return  false;
            }
        }
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=="cart_payment"){
            return vue_component_detail('discount');
        }
    }

    public function checkout_items(){
        $display=Session::get('discount_value',0)>0 ? "block" : 'none';
        return [
            'name'=>'checkout_discount',
            'title'=>'تخفیف',
            'value'=>get_price(Session::get('discount_value',0)),
            'display'=>$display,
            'type'=>'deduction',
        ];
    }

    public function checkout_final_price($data){
        $discount_value=Session::get('discount_value',0);
        if($discount_value>0){
            if(array_key_exists("normal",$data[1])){
                $data[1]['normal']= ($data[1]['normal'] - intval($discount_value));
            }
            if(array_key_exists("fast",$data[1])){
                $data[1]['fast']= ($data[1]['fast'] - intval($discount_value));
            }
            return $data;
        }
    }

    public function set_user_access_list($access){
        $access['discount']=[
            'label'=>'تخفیف',
            'access'=>[
                'discount_edit'=>['label'=>'ثبت و ویرایش کد تخفیف','routes'=>[
                    'discount.index','discount.create','discount.store','discount.edit','discount.update'
                ]],
                'remove_discount'=>['label'=>'حذف کد تخفیف','routes'=>['discount.index','discount.destroy']],
                'restore_discount'=>['label'=>'بازیابی کد تخفیف','routes'=>['discount.index','discount.restore']]
            ]
        ];

        return $access;
    }

    public function payment_page(): array{
        return [
            [
                'view'=>'discount::box-view',
                'index'=>0,
            ]
        ];
    }

    public function before_add_order($data){
        if(Session::has('discount_value')){
            $data['discount_value']=Session::get('discount_value');
            $data['discount_code']=Session::get('discount_code');
        }
        return $data;
    }

    public function order_detail($args){
        if(!empty($args['order']->discount_value)){
            $args['detail'][]=['label'=>'تخفیف','value'=>get_price($args['order']->discount_value)];
            $args['detail'][]=['label'=>'کد تخفیف','value'=>$args['order']->discount_code];
        }
        return $args;
    }

    public function after_payment(){
        Session::forget('discount_value');
        Session::forget('discount_code');
        if(Session::has('discount_id')){
            $key='user_'.\Auth::user()->id.'_discount_'.Session::get('discount_id');
            $value=cache()->get($key);
            if($value){
                $value=$value+1;
                cache()->set($key,$value);
            }
            else{
                cache()->set($key,1);
            }
        }
    }

    public function card_changed(){
        if(Session::has('discount_code')){
            Session::forget('discount_code');
            Session::forget('discount_value');
        }
    }

}
