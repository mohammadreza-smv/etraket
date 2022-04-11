<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCart extends Model
{
    protected $fillable=['user_id','order_id','credit_cart','credit_used','code'];
}
