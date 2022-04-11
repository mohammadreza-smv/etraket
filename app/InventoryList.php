<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InventoryList extends Model
{
    protected $fillable=['product_count','product_warranty_id','stockroom_id'];
    public static function getList($id,$request,$page_size=10,$seller_id=null)
    {
        $string='?';
        $getStockroom=$seller_id ? true : false;
        $title=$request->get('search_text','');
        $seller_id=$seller_id ? $seller_id : $request->get('seller_id','');
        define('search_text',$title);
        define('seller_id',$seller_id);
        $inventory_lists=self::orderBy('id','DESC')
        ->where('product_count','>',0)
        ->with(['getProductWarranty'=>function($query){
            $query->with(['getColor','getSeller','getWarranty','getProduct']);
        }])
        ->whereHas('getProductWarranty',function(Builder $query){
            if(!empty(search_text))
            {
                $query->whereHas('getProduct',function(Builder $query2){
                    $query2->where('title','like','%'.search_text.'%');
                });
            }
            else{
                $query->whereHas('getProduct');
            }
            if(!empty(seller_id) || seller_id=="0"){
                $query->where('seller_id',seller_id);
            }
        });
        if($id!="all")
        {
            $inventory_lists=$inventory_lists->where(['stockroom_id'=>$id]);
        }
        if($getStockroom)
        {
            $inventory_lists=$inventory_lists->with('getStockroom');
        }
        if(!empty(search_text)){
            $string=create_paginate_url($string,'title='.$request['title']);
        }
        if(!empty(seller_id)  || $seller_id=="0"){
            $string=create_paginate_url($string,'seller_id='.$request['seller_id']);
        }
        
        $inventory_lists=$inventory_lists->paginate($page_size);
        $inventory_lists->withPath($string);
        return $inventory_lists;
    }
    public function getProductWarranty()
    {
        return $this->hasone(ProductWarranty::class,'id','product_warranty_id')->withTrashed();
    }
    public function getStockroom()
    {
        return $this->hasOne(Stockroom::class,'id','stockroom_id');
    }
}
