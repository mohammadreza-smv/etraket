<?php


namespace Modules\faq;


use App\BaseModule;

class Module extends BaseModule
{
    public function registerComponent(){
        if(request()->is('faq/*') ||request()->is('faq')){
            return vue_component_detail('faq');
        }
    }
}
