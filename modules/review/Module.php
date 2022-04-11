<?php


namespace Modules\review;

use App\BaseModule;
use Modules\review\Repository\ReViewRepositoryInterface;

class Module extends BaseModule
{
    public function products_index_right_click(){
        return [
            'review'=>[
                'label'=>'ثبت نقد و بررسی تخصصی',
                'url'=>'product/review?product_id=:id',
                'icon'=>'mdi-file-find'
            ]
        ];
    }

    public function before_show_view($data){
        $routeName=getRouteName();
        if($routeName==='show_product'){
            $repository=app(ReViewRepositoryInterface::class);
            $review=$repository->getProductReview($data['product']->id);
            $data['review']=$review;
        }
        return $data;
    }

    public function set_user_child_access($access){

        if(array_key_exists('products',$access)){
            $access['products']['access']['review']=['label'=>'ثبت نقد و بررسی تخصصی','routes'=>[
                'review.primary','review.add.primary',
                'review.index','review.create','review.store','review.edit','review.update',
                'review.destroy','product/review.restore'
            ]];
        }
        return $access;
    }


    public function registerComponent(){
        if(!request()->has('request-type')){
            return vue_component_detail('review');
        }
    }

    public function install(){
        add_vue_components(
            base_path('modules/review/assets/min-components.js')
        );
    }
}
