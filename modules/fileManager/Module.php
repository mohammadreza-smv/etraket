<?php


namespace Modules\fileManager;

use App\BaseModule;

class Module extends BaseModule
{
    public function set_user_access_list($access){
        $access['files']=[
            'label'=>'مدیریت فایل ها',
            'access'=>[
                'files'=>['label'=>'امکان آپلود و حذف فایل ها','routes'=>['filemanager']],
            ]
        ];
        return $access;
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='filemanager'){
            return vue_component_detail('fileManager');
        }
    }
}
