<?php

namespace Modules\productStatusNotification;

use App\BaseModule;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Modules\productStatusNotification\Jobs\StatusNotification;
use Modules\productStatusNotification\Models\ProductStatusNotification;

class Module extends BaseModule
{
    public function product_not_available(){
        config()->set('view.productStatusNotification','add');
        return [
            [
                'view'=>'productStatusNotification::notification-btn',
                'index'=>0
            ]
        ];
    }

    public function registerComponent()
    {
        if (config()->get('view.productStatusNotification')==='add') {
            return vue_component_detail('productStatusNotification');
        }
    }

    public function before_show_view($data){
        $routeName=getRouteName();
        $sendStatusNotification=false;
        if($routeName=='show_product' && Auth::check()){
            $user=Auth::user();
            $sendStatusNotification=ProductStatusNotification::where(
                ['user_id'=>$user->id,'product_id'=>$data['product']->id]
            )->count();
        }
        $data['sendStatusNotification']=$sendStatusNotification;
        return $data;
    }

    public function products_updated($model){
        if($model->status==1 && $model->getOriginal('status')==0){
            StatusNotification::dispatch($model->id)->onQueue("low");
        }
    }

    public function products_request_relation(){
        return function($self){
            return  $self->hasMany(ProductStatusNotification::class,'product_id','id');
        };
    }
}
