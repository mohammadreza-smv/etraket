<?php

namespace Modules\messages\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends CustomModel
{
    use SoftDeletes;

    protected $guarded=['pic'];

    public  static function getMessage($user_id,$type='Modules\users\Models\User',$request=null)
    {
        $string = '?';
        $message=self::orderBy('updated_at','DESC')->with(['from','to']);
        if(inTrashed($request))
        {
            $message=$message->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if (array_key_exists('title', $request) && !empty($request['title'])) {
            $message = $message->where('title', 'like', '%' . $request['title'] . '%');
            $string = create_paginate_url($string, 'title=' . $request['title']);
        }
        $message =$message->where(['parent_id'=>0]);
        if($type!=null){
            $message=$message->where(['user_id'=>$user_id,'user_type'=>$type]);
        }
        $message=$message->paginate(10);
        $message->withPath($string);
        return $message;
    }
    public function from()
    {
       return $this->morphTo()->withDefault(['name'=>'پیام سیستم']);
    }
    public function to()
    {
        return $this->morphTo();
    }
    public function getContentAttribute($value)
    {
        return nl2br($value);
    }
    public function getAnswer()
    {
        return $this->hasMany(Message::class, 'parent_id','id');
    }
}
