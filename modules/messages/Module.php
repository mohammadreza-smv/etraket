<?php

namespace Modules\messages;
use App\BaseModule;
use Auth;
use Modules\messages\Repository\MessageRepositoryInterface;
use View;
class Module extends BaseModule
{
    public function users_index_action(){
        return function ($model){
            $url=url('admin/users/'.$model->id.'/messages');
            return view('messages::panel.message_list_icon',['url'=>$url])->render();
        };
    }

    public function user_panel_menu($data){
        $data[]=[
            'label'=>'پیغام های من',
            'icon'=>'mdi-email-outline',
            'url'=>url('user/profile/messages'),
            'count'=>'new_message_count'
        ];
        return $data;
    }


    public function user_profile($data){
        $user_id=Auth::user()->id;
        $repository=app(MessageRepositoryInterface::class);
        $count=$repository->getNuwUserMessageCount($user_id);
        View::share('new_message_count',$count);
    }

    public function load_user_panel_data(){
        $user_id=Auth::user()->id;
        $repository=app(MessageRepositoryInterface::class);
        $count=$repository->getNuwUserMessageCount($user_id);
        View::share('new_message_count',$count);
    }

    public function load_backend_data(){
        if(Auth::user()->role=='admin' || has_access_author_admin('message')){
            $repository=app(MessageRepositoryInterface::class);
            $message_count=$repository->count(['status'=>1]);
            View::share('message_count',$message_count);
        }
    }

    public function registerComponent(){
         $routeName=getRouteName();
         if(strstr($routeName,'message')){
             return vue_component_detail('messages');
         }
    }
}
