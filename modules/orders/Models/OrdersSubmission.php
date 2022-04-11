<?php


namespace Modules\orders\Models;


use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersSubmission extends CustomModel
{
    use SoftDeletes;

    protected $table='orders__submission';

    protected $guarded=[];

    public function products(){
        return $this->hasMany(OrderProducts::class,'submission_id','id')
            ->with(['param1','param2']);
    }

    public function events(){
        return $this->hasMany(SubmissionEvents::class,'submission_id','id');
    }

    public function product(){
        return $this->hasMany(OrderProducts::class,'submission_id','id');
    }
}
