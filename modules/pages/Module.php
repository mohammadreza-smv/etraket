<?php

namespace Modules\pages;

use App\BaseModule;

class Module extends BaseModule
{
    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='show_page'){
            return vue_component_detail('pages');
        }
    }
}
