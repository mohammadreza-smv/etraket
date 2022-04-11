<?php

namespace Modules\productStatusNotification\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\Builder;
use Modules\products\Models\Product;

class ProductStatusNotification extends CustomModel
{
    protected $table='product_status_notification';

    protected $guarded=[];

    public static function products($request){
        $productsId=self::pluck('product_id','product_id')->toArray();
        $products=Product::whereIn('id',$productsId)->withCount('request');
        $title=$request->get('title');
        $string='?';
        if(!empty($title)){
            $string=create_paginate_url($string,'title='.$title);
            $products=$products->where('title','like','%'.$title.'%');
        }

        $products=$products->paginate(10);
        $products->withPath($string);
        return $products;
    }

}
