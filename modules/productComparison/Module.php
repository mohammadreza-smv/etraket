<?php

namespace Modules\productComparison;

use App\BaseModule;

class Module extends BaseModule
{
    public function registerComponent(){
           return vue_component_detail('productComparison');
    }

    public function desktop_layout(){
        $array=[
                [
                    'view'=>'productComparison::layout-view',
                    'index'=>0,
                ]
        ];
        return $array;
    }
}
