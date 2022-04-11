<?php

namespace Modules\questions\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mail;
use DB;
use Modules\questions\Mail\SendAnswer;

class Question extends CustomModel
{
    use SoftDeletes;

    protected $guarded=[];

    public $timestamps=false;

    public static function getData($request)
    {
        $relations=CompleteData('product_question_relations',['getParent']);
        $string='?';
        $questions=self::with($relations)
            ->orderBy('id','DESC');
        if(inTrashed($request))
        {
            $questions=$questions->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('user_id',$request) && !empty($request['user_id']))
        {
            $questions=$questions->where('user_id',$request['user_id']);
            $string=create_paginate_url($string,'user_id='.$request['user_id']);
        }
        $questions=$questions->paginate(10);
        $questions->withPath($string);
        return $questions;
    }

    public function getParent()
    {
        return $this->belongsTo(Question::class,'question_id','id');
    }

    public static function sendAnswerEmail($answer){
        $relations=CompleteData('product_question_relations',[]);
        $question=Question::with($relations)->where(['id'=>$answer->question_id,'send_email'=>'ok'])->first();
        if($question && $question->user)
        {
            if(!empty($question->user->email))
            {
                Mail::to($question->user->email)->queue(new SendAnswer($question,$answer));
            }
        }
    }

    public static function updateAnswerCount($question_id,$status)
    {
        $question=Question::where(['id'=>$question_id,'question_id'=>0])->first();
        if($question)
        {
            if($status==1)
            {
                $question->answer_count=$question->answer_count+1;
            }
            else{
                $question->answer_count=$question->answer_count-1;
            }
            $question->update();
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($row){
            if(!$row->isForceDeleting())
            {
                if($row->question_id>0)
                {
                    DB::table('questions')->where('id',$row->question_id)->decrement('answer_count',1);
                }
            }
        });
        static::restoring(function ($row){
            DB::table('questions')->where('id',$row->question_id)->increment('answer_count',1);
        });
    }

    public function answer(){
        return $this->hasMany(Question::class,'question_id','id')
            ->where('status',1);
    }

    public function getQuestionAttribute($value)
    {
        return strip_tags(nl2br($value),'<br>');
    }
}
