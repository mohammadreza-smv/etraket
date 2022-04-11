<?php

namespace Modules\city\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\province\Models\Province;

class City extends CustomModel
{
    use SoftDeletes;
    protected $table='city';
    protected $guarded=[];
    public static function getData($request)
    {
        $string='?';
        $city=self::orderBy('id','DESC')->with('getProvince');
        if(inTrashed($request))
        {
            $city=$city->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('string',$request) && !empty($request['string']))
        {
            $city=$city->where('name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'string='.$request['string']);
        }
        $city=$city->paginate(10);
        $city->withPath($string);
        return $city;
    }
    public function getProvince()
    {
        return $this->hasOne(Province::class,'id','province_id')->withDefault(['name'=>'']);
    }
}
