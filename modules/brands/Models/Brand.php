<?php

namespace Modules\brands\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends CustomModel
{
    use SoftDeletes;

    protected $table='brands';

    protected $guarded=['pic'];

    public static function getData($request)
    {
        $string='?';
        $brand=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $brand=$brand->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $brand=$brand->where('brand_name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $brand=$brand->paginate(10);
        $brand->withPath($string);
        return $brand;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($brand){
            if($brand->isForceDeleting())
            {
                if(!empty($brand->brand_icon) && file_exists('files/upload/'.$brand->brand_icon))
                {
                    unlink('files/upload/'.$brand->brand_icon);
                }
            }
        });
    }

    public function getCat()
    {
        return $this->hasMany(CatBrand::class,'brand_id','id');
    }
}
