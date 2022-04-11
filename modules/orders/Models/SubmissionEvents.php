<?php


namespace Modules\orders\Models;


use App\CustomModel;
use Modules\users\Models\User;

class SubmissionEvents extends CustomModel
{
    protected $guarded=[];

    protected $table='orders__submission_events';

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
