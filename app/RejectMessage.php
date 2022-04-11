<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectMessage extends Model
{
    protected $table='reject_message';

    public  function getUser()
    {
       return $this->hasOne(User::class,'id','user_id');
    }
}
