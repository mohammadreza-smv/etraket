<?php

namespace Modules\colors\Models;


use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends CustomModel
{
    use SoftDeletes;

    protected $table='colors';

    protected $guarded=[];

    static public $label='رنگ';

    public static function getData($request)
    {
        $string='?';
        $color=self::orderBy('id','DESC')->where('type',1);
        if(inTrashed($request))
        {
            $color=$color->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $color=$color->where('name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $color=$color->paginate(10);
        $color->withPath($string);
        return $color;
    }

    public function getCodeAttribute($value){
        if(request()->is('api/*')){
            $value='#'.$value;
        }
        return $value;
    }
}
