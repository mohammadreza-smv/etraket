<?php


namespace Modules\priceVariation\Models;


use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\products\Models\Product;

class PriceVariation extends CustomModel
{
    use SoftDeletes;
    protected $table='product_price_variation';
    protected $guarded=[];

    public static function getData($request,$product_id=0)
    {
        $string='?';
        $relation=['param1','param2'];
        $relation=CompleteData('price_variation_list_relation',$relation);
        $priceVariation=self::orderBy('id','DESC')->with($relation);
        if(inTrashed($request)){
            $priceVariation=$priceVariation->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        $product_id= $product_id > 0 ? $product_id : $request['product_id'];
        $priceVariation=$priceVariation->where('product_id',$product_id);
        $priceVariation=CompleteData('price_variation_panel_list',$priceVariation);
        $priceVariation=$priceVariation->paginate(10);
        $priceVariation->withPath($string);
        return $priceVariation;
    }

    public function param1()
    {
        return $this->morphTo();
    }
    public function param2()
    {
        return $this->morphTo();
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
