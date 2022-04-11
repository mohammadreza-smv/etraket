<?php

namespace Modules\sliders;

use App\BaseModule;
use View;
use Request;
class Module extends BaseModule
{
    public function set_user_access_list($access){
        $access['sliders']=[
            'label'=>'اسلایدر ها',
            'access'=>[
                'slider_edit'=>['label'=>'ثبت و ویرایش اسلایدر','routes'=>[
                    'sliders.index','sliders.create','sliders.store','sliders.edit','sliders.update'
                ]],
                'remove_slider'=>['label'=>'حذف اسلایدرها','routes'=>['sliders.index','sliders.destory']],
                'restore_slider'=>['label'=>'بازیابی اسلایدرها','routes'=>['sliders.index','sliders.restore']]
            ]
        ];

        return $access;
    }

    public function widgets(){
        return [
            [
                'name'=>'slider',
                'title'=>'اسلایدر',
                'view'=>'sliders::desktop',
            ]
        ];
    }

    public function registerComponent($theme,$type){
        $routeName=getRouteName();
        if($routeName=='home'){
            return vue_component_detail('sliders');
        }
    }
}
