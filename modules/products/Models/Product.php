<?php

namespace Modules\products\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Mail;
use App\Mail\ProductStatus;
use Modules\categories\Models\Category;
use Modules\priceVariation\Models\PriceVariation;

class Product extends CustomModel
{
    use SoftDeletes;

    protected $table='products';

    protected $guarded=['tag_list','pic'];

    public static function ProductStatus()
    {
        $array=array();
        $array[-3]='رد شده';
        $array[-2]='در انتظار بررسی';
        $array[-1]='توقف تولید';
        $array[0]='ناموجود';
        $array[1]='منتشر شده';

        return $array;
    }

    public static function getData($request)
    {
        $string='?';

        $relation=CompleteData('product_list_relation',[]);

        $products=self::with($relation);

        if(inTrashed($request)){
            $products=$products->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        else{
            $products=$products->whereNull('deleted_at');
        }

        if(array_key_exists('order_by',$request)){
            if($request['order_by']=='new'){
                $products=$products->orderBy('id','DESC');
                $string=create_paginate_url($string,'order_by='.$request['order_by']);
            }
        }
        else{
            $products=$products->orderBy('id','DESC');
        }

        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $products=$products->where('title','like','%'.$request['string'].'%');
            $products=$products->orWhere('ename','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }

        if(array_key_exists('status',$request) && $request['status']!=''){
            $products=$products->where('status',$request['status']);
            $string=create_paginate_url($string,'status='.$request['status']);
        }

        $data=CompleteData('select_product_list',[$products,$string]);

        $products=$data[0];
        $string=$data[1];

        $products=$products->paginate(10);
        $products->withPath($string);

        return $products;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            if ($product->isForceDeleting()) {
                remove_file($product->image_url,'products');
                remove_file($product->image_url,'thumbnails');
                DB::table('product_color')->where('product_id',$product->id)->delete();
                DB::table('item_value')->where('product_id',$product->id)->delete();
                PriceVariation::where('product_id',$product->id)->delete();
                DB::table('review_product')->where('product_id',$product->id)->delete();
            }
        });
    }

    public function getCat()
    {
        return $this->hasOne(Category::class,'id','cat_id')->withDefault(['name'=>'']);
    }

}
