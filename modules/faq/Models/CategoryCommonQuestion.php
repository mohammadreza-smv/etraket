<?php

namespace Modules\faq\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryCommonQuestion extends CustomModel
{
    use SoftDeletes;
    protected $fillable=['title'];
    public static function getData($request)
    {
        $string='?';
        $category=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $category=$category->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('title',$request) && !empty($request['title']))
        {
            $category=$category->where('title','like','%'.$request['title'].'%');
            $string=create_paginate_url($string,'title='.$request['title']);
        }
        $category=$category->paginate(10);
        $category->withPath($string);
        return $category;
    }
}
