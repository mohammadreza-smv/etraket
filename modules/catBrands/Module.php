<?php

namespace Modules\catBrands;

use App\BaseModule;
use Modules\brands\Models\Brand;
use Modules\catBrands\Models\CatBrand;
use Modules\catBrands\Repository\CatBrandRepositoryInterface;

class Module extends BaseModule
{
    public function products_created($model){
        $repository=app(CatBrandRepositoryInterface::class);
        $repository->addCatBrand($model,null);
    }

    public function products_updated($model){
        $oldData=['cat_id'=>$model->getOriginal('cat_id'),'brand_id'=>$model->getOriginal('brand_id')];
        $repository=app(CatBrandRepositoryInterface::class);
        $repository->addCatBrand($model,$oldData);
    }

    public function search_product_query($query){
        $request=request();
        if($request->route()->parameter('brand_name')){
            $brand_name=$request->route()->parameter('brand_name');
            $brand=Brand::where('brand_ename',$brand_name)->first();
            if($brand){
                $query=$query->where('brand_id',$brand->id);
            }
            $categories=$request->get('category');
            if($request->has('category')){
                 $query=$query->whereIn('cat_id',$categories);
            }
        }
        return $query;
    }

    public function search_filters($args){
        $previous_url=url()->previous();
        if(str_contains($previous_url,'brand')){
            $brand_name=str_replace(url('brand/'),'',$previous_url);
            $brand_name=str_replace('/','',$brand_name);
            $brand=Brand::where('brand_ename',$brand_name)->first();
            if($brand){
                $categories=[];
                $result=CatBrand::where('brand_id',$brand->id)->with('getCategory')->get();
                foreach ($result as $value){
                    if($value->getCategory){
                        $categories[]=['id'=>$value->cat_id,'title'=>$value->getCategory->name];
                    }
                }
                $args['customItems'][]=['items'=>$categories,'title'=>'دسته بندی ها','param'=>'category'];
            }
        }
        return $args;
    }
}
