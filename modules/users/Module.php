<?php

namespace Modules\users;

use App\BaseModule;
use Modules\users\Repository\AdditionalInfoRepositoryInterface;
use View;
class Module extends BaseModule
{
    protected $user_access=null;

    public function registerComponent(){
        if(!request()->is('admin/*')){
            return vue_component_detail('users');
        }
    }

    public function getUserAccess(){
        if($this->user_access==null){
            $this->user_access=getAllAccess();
            return $this->user_access;
        }
        else{
            View::share('access',$this->user_access);
            return $this->user_access;
        }
    }

    public function set_user_access_list($access){

        $access['users']=[
            'label'=>'کاربران',
            'access'=>[
                'discount_edit'=>['label'=>'ثبت و ویرایش کاربر','routes'=>[
                    'users.index','users.create','users.store','users.edit','users.update'
                ]],
                'remove_users'=>['label'=>'حذف کاربر','routes'=>['users.index','users.destroy']],
                'restore_users'=>['label'=>'بازیابی کاربر','routes'=>['users.index','users.restore']]
            ]
        ];

        return $access;
    }

    public function user_panel_index(){
        if(view_type==''){
            return [
                [
                    'index'=>0,
                    'view'=>'users::user-panel.register-detail'
                ]
            ];
        }
    }

    public function before_show_view($data){
        $routeName=getRouteName();
        if($routeName==='user_profile'){
            $repository=app(AdditionalInfoRepositoryInterface::class);
            $additionalInfo=$repository->first(request());
            $data['additionalInfo']=$additionalInfo;
            $data['personal_user_detail']=personal_user_detail($additionalInfo);
            return $data;
        }
        return $data;
    }

    public function registered($user){
        $code=$user->active_code;
        send_auth_sms($user,$code);
    }

    public function desktop_layout(){
        return [
            [
                'view'=>'users::auth.login_dialog',
                'index'=>0,
            ]
        ];
    }

    public function mobile_layout(){
        return [
            [
                'view'=>'users::auth.mobile_login_box',
                'index'=>0,
            ]
        ];
    }
}
