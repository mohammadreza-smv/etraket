<?php

namespace Modules\review\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReView extends CustomModel
{
    use SoftDeletes;
    protected $table='review_product';
    protected $guarded=[];
    public static function getData($request)
    {
        $string='?';
        $review=self::orderBy('id','DESC')->where('product_id',$request['product_id'])->whereNotNull('title');
        if(inTrashed($request))
        {
            $review=$review->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        else{
            $review=$review->whereNull('deleted_at');
        }

        $review=$review->paginate(10);
        $review->withPath($string);
        return $review;
    }
}
