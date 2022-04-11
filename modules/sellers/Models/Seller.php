<?php

namespace Modules\sellers\Models;

use Modules\users\Models\Foundation\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\priceVariation\Models\PriceVariation;

class Seller extends Authenticatable
{
   use SoftDeletes;

   use HasApiTokens;

   use Notifiable;

   protected $guarded=[];

   protected $hidden = [
        'password',
   ];

   public static function getData($request)
   {
        $string = '?';
        $sellers = self::withCount('product');
        if (inTrashed($request)) {
            $sellers = $sellers->onlyTrashed();
            $string = create_paginate_url($string, 'trashed=true');
        }
        if (array_key_exists('brand_name', $request) && !empty($request['brand_name'])) {
            $sellers = $sellers->where('brand_name', 'like', '%' . $request['brand_name'] . '%');
            $string = create_paginate_url($string, 'brand_name=' . $request['brand_name']);
        }
        $sellers = $sellers->orderBy('id', 'DESC')->paginate(10);
        $sellers->withPath($string);
        return $sellers;
   }

   public function product()
   {
        return $this->hasMany(SellerProduct::class,'seller_id','id');
   }

   protected static function boot()
   {
        parent::boot();

        static::deleting(function($seller){
            if(class_exists(PriceVariation::class)){
                if(!$seller->isForceDeleting() && $seller->account_status=='active')
                {
                    PriceVariation::where(['seller_id'=>$seller->id,'status'=>1])->update(['status'=>2]);
                    PriceVariation::where(['seller_id'=>$seller->id])->delete();
                }
            }
        });

        static::restoring(function ($seller){
            if($seller->account_status=='active')
            {
                if(!$seller->isForceDeleting() && $seller->account_status=='active'){
                    PriceVariation::where(['seller_id'=>$seller->id,'status'=>2])
                        ->withTrashed()
                        ->update(['status'=>1,'deleted_at'=>null]);
                }
            }
        });
   }
}
