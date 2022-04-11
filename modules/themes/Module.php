<?php

namespace Modules\themes;

use App\BaseModule;

class Module extends BaseModule
{
    public function registerComponent($theme,$type){
        $routeName=getRouteName();
        if($routeName=='theme_widgets'){
            return vue_component_detail('themes');
        }
        else{
            return vue_component_detail('front-theme','./modules/themes/resource/js/front-components.js');
        }
    }
}
