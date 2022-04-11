<?php

namespace Modules\comments\Models;

use App\CustomModel;

class CommentScore extends CustomModel
{
    protected $table='comment_scores';
    protected $guarded=[];
    public static  function getScoreTypeLabel()
    {
        $type=[
            'خیلی بد',
            'بد',
            'معمولی',
            'خوب',
            'عالی'
        ];
        return $type;
    }
}
