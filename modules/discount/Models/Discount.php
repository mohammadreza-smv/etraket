<?php

namespace Modules\discount\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
class Discount extends CustomModel
{
    protected $table='discount_codes';
    use SoftDeletes;
    protected $guarded=[];
    public static function getData($request)
    {
        $string='?';
        $discount=self::orderBy('id','DESC');

        if(inTrashed($request))
        {
            $discount=$discount->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        else{
            $discount=$discount->whereNull('deleted_at');
        }

        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $discount=$discount->where('code','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $discount=$discount->paginate(10);
        $discount->withPath($string);
        return $discount;
    }
}
