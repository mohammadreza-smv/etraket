<?php

namespace Modules\comments\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;
class Comment extends CustomModel
{
    use SoftDeletes;

    protected $guarded=['score_item'];

    public static function getData($request)
    {
        $string='?';
        $relation=CompleteData('show_all_comment_relations',['getScore']);
        $comments=self::with($relation)->whereHas('getScore')->orderBy('id','DESC');
        if(inTrashed($request))
        {
            $comments=$comments->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('user_id',$request) && !empty($request['user_id']))
        {
            $comments=$comments->where('user_id',$request['user_id']);
            $string=create_paginate_url($string,'user_id='.$request['user_id']);
        }
        $comments=$comments->paginate(10);
        $comments->withPath($string);
        return $comments;
    }

    public function getScore()
    {
        return $this->hasOne(CommentScore::class,'comment_id','id');
    }

    public function getAdvantageAttribute($value)
    {
        $e=explode('|[@#]|',$value);
        return $e;
    }

    public function getDisadvantageAttribute($value)
    {
        $e=explode('|[@#]|',$value);
        return $e;
    }

}
