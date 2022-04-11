<?php


namespace Modules\favourite;

use App\BaseModule;
use Auth;
use Modules\favourite\Repository\FavoriteRepositoryInterface;

class Module extends BaseModule
{
    public function before_show_view($args){
        if(getRouteName()==='show_product'){
            $favorite=null;
            if(Auth::check())
            {
                $repository=app(FavoriteRepositoryInterface::class);
                $user_id=Auth::user()->id;
                $favorite=$repository->checkSelected($user_id,$args['product']->id);
            }
            $args['favorite']=$favorite;
        }
        return  $args;
    }

    public function user_panel_menu($data){
        $data[]=[
            'label'=>' لیست علاقه مندی ها',
            'icon'=>'mdi-star',
            'url'=>url('user/profile/favorite'),
        ];
        return $data;
    }

    public function registerComponent(){
        if(!request()->has('request-type')){
            return vue_component_detail('favourite');
        }
    }

    public function install(){
        add_vue_components(
            base_path('modules/favourite/assets/min-components.js')
        );
    }
}
