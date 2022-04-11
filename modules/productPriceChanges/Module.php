<?php

namespace Modules\productPriceChanges;

use App\BaseModule;
use Modules\productPriceChanges\Models\Changes;

class Module extends BaseModule
{
    public function product_price_variation_updated($model){
        new Changes($model);
    }

    public function product_price_variation_created($model){
        new Changes($model);
    }

    public function product_price_variation_restored($model){
        new Changes($model);
    }

    public function product_price_variation_deleted($model){
       new Changes($model,'deleted');
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='show_product'){
            return vue_component_detail('productPriceChanges');
        }
    }
}
