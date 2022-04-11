<?php

namespace Modules\panelTheme;

use App\BaseModule;

class Module extends BaseModule
{
    public function registerComponent($theme,$type){
        if(request()->is('admin/*') || request()->is('admin') || config('view.build_component')=='add'){
            return vue_component_detail('panelTheme');
        }
    }
}
