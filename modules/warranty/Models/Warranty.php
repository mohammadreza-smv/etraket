<?php

namespace Modules\warranty\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warranty extends Model
{
    use SoftDeletes;

    protected $table='warranties';

    protected $guarded=[];

    static public $label='گارانتی';

    public static function getData($request)
    {
        $string="?";
        $warranty=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $warranty=$warranty->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $warranty=$warranty->where('name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $warranty=$warranty->paginate(10);
        $warranty->withPath($string);
        return $warranty;
    }
}
