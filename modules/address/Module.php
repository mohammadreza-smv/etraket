<?php


namespace Modules\address;

use App\BaseModule;
use Auth;
use Modules\address\Models\Address;
use Modules\address\Repository\AddressRepositoryInterface;
use Request;
use Session;
class Module extends BaseModule
{
    public function before_show_view($data){
        $routeName=getRouteName();
        if($routeName==='shipping_set_data'){
            $repository=app(AddressRepositoryInterface::class);
            $user_id=Auth::user()->id;
            $address=$repository->all($user_id);
            $data['address']=$address;
        }
        return $data;
    }


    public function user_panel_menu($data){
        $data[]=[
            'label'=>'نشانی ها',
            'icon'=>'mdi-map-marker',
            'url'=>url('user/profile/address'),
        ];
        return $data;
    }

    public function before_payment_method($user_id,$request){
        $address_id=$request->has('address_id') ? $request->get('address_id') : Session::get('order_address_id');
        $repository=app(AddressRepositoryInterface::class);
        $address_id=intval($address_id);
        $address=$repository->first(['id'=>$address_id,'user_id'=>$user_id]);
        if($address){
            Session::put('order_address_id',$address->id);
            view()->share('address',$address);
        }
        else{
            throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect('/Cart'));
        }
    }

    public function set_order_payment_data($shoppingCart){
        if(isset($_POST['city_id'])){
            $shoppingCart->city_id=intval($_POST['city_id']);
        }
        else if(defined('city_id')){
            $shoppingCart->city_id=intval(city_id);
        }
    }

    public function before_order_payment($user_id){
        if(Session::has('order_address_id')){

            $address_id=intval(Session::get('order_address_id'));
            $repository=app(AddressRepositoryInterface::class);
            $address=$repository->first(['id'=>$address_id,'user_id'=>$user_id]);
            if($address){
                define('city_id',$address->city_id);
                define('address_id',$address->id);
            }
            else{
                throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect('/Cart'));
            }
        }
        else{
            throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect('/Cart'));
        }
    }

    public function order_detail_relation($array){
        $array[]='address.getProvince';
        $array[]='address.getCity';
        return $array;
    }

    public function orders__list_address_relation(): \Closure
    {
        return function($self){
            return $self->belongsTo(Address::class,'address_id','id');
        };
    }

    public function order_detail($args){
        $array=$args['detail'];
        $order=$args['order'];
        if($order->address){
            $array[]=[
                'label'=>'تحویل گیرنده:',
                'value'=>$order->address->name
            ];

            $array[]=[
                'label'=>' شماره تماس تحویل گیرنده:',
                'value'=>$order->address->mobile
            ];

            $array[]=[
                'label'=>' آدرس تحویل گیرنده:',
                'value'=>$order->address->getProvince->name.' '. $order->address->getCity->name.' '. $order->address->address,
            ];

            $args['detail']=$array;
        }
        return $args;
    }

    public function registerComponent($theme,$type){
        $route_name=getRouteName();
        if($route_name=='profile_address' || $route_name=='shipping_set_data'){
            return vue_component_detail('address');
        }
    }
}
