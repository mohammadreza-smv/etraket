<?php


namespace Modules\categories;

use App\BaseModule;
use Modules\categories\Models\Category;
use Modules\categories\Repository\CategoryRepositoryInterface;

class Module extends BaseModule
{
    public function category_create_form(): array
    {
       return [
           'after_parent_id'=>'categories::checkBox',
       ];
    }

    public function category_edit_form(): array
    {
        return [
            'after_parent_id'=>'categories::checkBox'
        ];
    }

    public function category_saving($model){
        if(request()->has('name')){
            $notShow=request()->has('notShow') ? 1 : 0;
            $model->notShow=$notShow;
            cache()->forget('catList');
        }
    }

    public function product_form_right_box(){
        return 'categories::select_list';
    }

    public function set_user_access_list($access){
        $access['category']=[
            'label'=>'دسته بندی',
            'access'=>[
                'category_edit'=>['label'=>'ثبت و ویرایش دسته بندی','routes'=>[
                    'category.index','category.create','category.store','category.edit','category.update'
                ]],
                'remove_category'=>['label'=>'حذف دسته','routes'=>['category.index','category.destroy']],
                'restore_category'=>['label'=>'بازیابی دسته','routes'=>['category.index','category.restore']]
            ]
        ];

        return $access;
    }

    public function products_index_form(){
        return [
            'before_status'=>'categories::products_index'
        ];
    }

    public function before_show_view($args){
        $routeName=getRouteName();
        if(getRouteName()==='products_index'){
            $catRepository=app(CategoryRepositoryInterface::class);
            $catList=$catRepository->catList();
            $catList[0]='همه دسته ها';
            view()->share('catList',$catList);
        }
        else{
            if($routeName==='products_create' || $routeName==='products_edit'){
                $repository=app(CategoryRepositoryInterface::class);
                $catList=$repository->catList2();
                view()->share('catList',$catList);
            }
        }
        return $args;
    }

    public function select_product_list($data){

        $products=$data[0];
        $string=$data[1];
        $request=request()->all();
        if(array_key_exists('cat_id',$request) && !empty($request['cat_id'])){

            $catId=Category::getCatIdWithChild($request['cat_id']);
            $products=$products->whereIn('cat_id',$catId);
            $string=create_paginate_url($string,'cat_id='.$request['cat_id']);

        }
        return [$products,$string];
    }

}
