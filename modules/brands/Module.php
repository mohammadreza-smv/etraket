<?php


namespace Modules\brands;

use App\BaseModule;
use Modules\brands\Models\Brand;
use Modules\brands\Repository\BrandRepositoryInterface;

class Module extends BaseModule
{
    public function product_form_right_box(){
        return 'brands::select_list';
    }

    public function show_product_relation($data){
        $data[]='getBrand';
        return $data;
    }

    public function set_user_access_list($access){
        $access['brands']=[
            'label'=>'برند ها',
            'access'=>[
                'brand_edit'=>['label'=>'ثبت و ویرایش برند','routes'=>[
                    'brands.index','brands.create','brands.store','brands.edit','brands.update'
                ]],
                'remove_brand'=>['label'=>'حذف برند','routes'=>['brands.index','brands.destroy']],
                'restore_brand'=>['label'=>'بازیابی برند','routes'=>['brands.index','brands.restore']]
            ]
        ];

        return $access;
    }

    public function products_index_form(){
        return [
            'after_status'=>'brands::products_index'
        ];
    }

    public function before_show_view($args){
        $routeName=getRouteName();
        if($routeName==='products_index'){
            $catRepository=app(BrandRepositoryInterface::class);
            $brands=$catRepository->selectList();
            view()->share('brands',$brands);
        }
        else{
            if($routeName==='products_create' || $routeName==='products_edit'){
                $repository=app(BrandRepositoryInterface::class);
                $brand=$repository->selectList();
                view()->share('brand',$brand);
            }
        }
        return $args;
    }

    public function select_product_list($data){
        $products=$data[0];
        $string=$data[1];
        $request=request()->all();
        if(array_key_exists('brand_id',$request) && !empty($request['brand_id'])){
            $products=$products->where('brand_id',$request['brand_id']);
            $string=create_paginate_url($string,'brand_id='.$request['brand_id']);
        }
        return [$products,$string];
    }

    public function registerComponent(){
        if(config('view.search_components')==true){
            return vue_component_detail('brands');
        }
    }
}
