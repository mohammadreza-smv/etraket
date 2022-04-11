<?php

namespace Modules\salesReport;

use App\BaseModule;
use Modules\salesReport\jobs\ProvinceSale;

class Module extends BaseModule
{
    public function after_payment($data){
        $order_id=$data['order_id'];
        ProvinceSale::dispatch($order_id)->delay(now()->addSecond(60));
    }


    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName==='province_sale'){
            return vue_component_detail('salesReport');
        }
    }
}
