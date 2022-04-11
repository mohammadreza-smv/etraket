<?php


namespace Modules\catBrands\Repository;


use Modules\catBrands\Models\CatBrand;

class EloquentCatBrandRepository implements CatBrandRepositoryInterface
{

    public function create($cat_id, $brand_id)
    {
        $CatBrand=new CatBrand();
        $CatBrand->cat_id=$cat_id;
        $CatBrand->brand_id=$brand_id;
        $CatBrand->product_count=1;
        $CatBrand->save();
    }

    public function CreateOrUpdate($cat_id, $brand_id)
    {
        $row=CatBrand::where(['cat_id'=>$cat_id,'brand_id'=>$brand_id])->first();
        if($row){
            $product_count=$row->product_count+1;
            $row->product_count=$product_count;
            $row->update();
        }
        else{
            $this->create($cat_id,$brand_id);
        }
    }

    public function RemoveCatBrand($cat_id,$brand_id){
        $row=CatBrand::where(['cat_id'=>$cat_id,'brand_id'=>$brand_id])->first();
        if($row && $row->product_count>1){
            $product_count=$row->product_count-1;
            $row->product_count=$product_count;
            $row->update();
        }
        else{
            if($row){
                $row->delete();
            }
        }
    }

    public function addCatBrand($product,$oldData)
    {
        if($oldData){
            if($oldData['cat_id']!=$product->cat_id)
            {
                $this->create($product->cat_id,$product->brand_id);
                $this->RemoveCatBrand($oldData['cat_id'],$oldData['brand_id']);
            }
            elseif($oldData['brand_id']!=$product->brand_id){
                $this->CreateOrUpdate($product->cat_id,$product->brand_id);
                $this->RemoveCatBrand($oldData['cat_id'],$oldData['brand_id']);
            }
        }
        else
        {
            $this->CreateOrUpdate($product->cat_id,$product->brand_id);
        }
    }

    public function getWithRelation($relation, $where)
    {
        $brands=CatBrand::with($relation)->where($where)->get();
        return $brands;
    }
}
