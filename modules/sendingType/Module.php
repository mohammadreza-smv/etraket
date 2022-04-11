<?php

namespace Modules\sendingType;

use App\BaseModule;
use Modules\sendingType\Models\Cart;
use Modules\sendingType\Models\SendingMethod;
use Modules\sendingType\Repository\SendingTypeRepositoryInterface;

class Module extends BaseModule
{
    public function city_create_form(){
        return [
            'after_province_id'=>'sendingType::city_inputs',
        ];
    }

    public function city_edit_form(){
        return [
            'after_province_id'=>'sendingType::city_inputs',
        ];
    }

    public function before_show_view($data){
        $routeName=getRouteName();
        if($routeName=='city_create' || $routeName=='city_edit'){
            $this->set_sending_type_data();
        }
    }
    protected function set_sending_type_data(){
        $repository=app(SendingTypeRepositoryInterface::class);
        $sending_type=$repository->all();
        view()->share('sending_type',$sending_type);
    }

    public function shopping_cart_data($data){
         $city_id=array_key_exists('city_id',$data) ? $data['city_id'] : 0;
         $sendingMethod=new SendingMethod($data,$city_id);
         return $sendingMethod->result();
    }

    public function products_create_form(){
        return [
            'after_status'=>'sendingType::product_weight_input',
        ];
    }

    public function products_edit_form(){
        return [
            'after_status'=>'sendingType::product_weight_input'
        ];
    }

}
