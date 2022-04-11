<?php

namespace Modules\blog\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends CustomModel
{
    use SoftDeletes;

    protected $table='blog__category';

    protected $guarded=[];

    public static function getData($request)
    {
        $string='?';
        $category=self::with('parent');
        if(inTrashed($request))
        {
            $category=$category->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $category=$category->where('name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $category=$category->orderBy('id','DESC')->paginate(10);
        $category->withPath($string);
        return $category;
    }

    public function parent()
    {
        return $this->hasOne(BlogCategory::class,'id','parent_id')
            ->withTrashed()->withDefault(['name'=>'-']);
    }

    public function child(){
        return $this->hasMany(BlogCategory::class,'parent_id');
    }
}
