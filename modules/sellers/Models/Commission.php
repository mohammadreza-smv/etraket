<?php

namespace Modules\sellers\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\brands\Models\Brand;
use Modules\categories\Models\Category;

class Commission extends CustomModel
{
    use SoftDeletes;

    protected $guarded=[];

    public static function getData($request)
    {
        $string='?';
        $relation=[];
        if(file_exists(base_path('modules/brands/Models/Brand.php'))){
            $relation[]='brand';
        }
        if(file_exists(base_path('modules/categories/Models/Category.php'))){
            $relation[]='category';
        }
        $commissions=self::orderBy('id','DESC')->with($relation);
        if(inTrashed($request))
        {
            $commissions=$commissions->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('brand_id',$request) && !empty($request['brand_id']))
        {
            $commissions=$commissions->where('brand_id',$request['brand_id']);
            $string=create_paginate_url($string,'string='.$request['brand_id']);
        }
        if(array_key_exists('cat_id',$request) && !empty($request['cat_id']))
        {
            $commissions=$commissions->where('cat_id',$request['cat_id']);
            $string=create_paginate_url($string,'string='.$request['cat_id']);
        }
        $commissions=$commissions->paginate(10);
        $commissions->withPath($string);
        return $commissions;
    }

}
