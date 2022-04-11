<?php

namespace Modules\faq\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonQuestion extends CustomModel
{
    use SoftDeletes;
    protected $fillable=['title','cat_id','answer','small_answer','pin'];
    public static function getData($request)
    {
        $string='?';
        $question=self::with('cat');
        if(inTrashed($request))
        {
            $question=$question->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('title',$request) && !empty($request['title']))
        {
            $question=$question->where('title','like','%'.$request['title'].'%');
            $string=create_paginate_url($string,'string='.$request['title']);
        }
        $question=$question->orderBy('id','DESC')->paginate(10);
        $question->withPath($string);
        return $question;
    }
    public function cat(){
        return $this->hasOne(CategoryCommonQuestion::class,'id','cat_id')
            ->withDefault(['title'=>'']);
    }
}
