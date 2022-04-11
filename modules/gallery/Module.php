<?php

namespace Modules\gallery;

use App\BaseModule;
use Modules\gallery\Models\ProductGallery;

class Module extends BaseModule
{
    public function products_index_right_click(){
        return [
            'gallery'=>[
                'label'=>'گالری تصاویر محصول',
                'url'=>'products/gallery/:id',
                'icon'=>'mdi-image-multiple'
            ]
        ];
    }

    public function show_product_relation($data){
        $data[]='Gallery';
        return $data;
    }

    public function products_Gallery_relation(){
        return function($self){
            return  $self->hasMany(ProductGallery::class,'product_id','id')
                ->orderBy('position','ASC');
        };
    }

    public function set_user_child_access($access){

        if(array_key_exists('products',$access)){
            $access['products']['access']['gallery']=['label'=>'ثبت گالری تصاویر','routes'=>[
                'product.gallery','product.add_gallery','product.remove_gallery','product.gallery_change_status'
            ]];
        }
        return $access;
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='show_product'){
            return vue_component_detail('gallery');
        }
        elseif($routeName=='product_gallery' ||  config('view.panel-gallery')=='add'){
            return vue_component_detail('panel-gallery');
        }
    }
}
