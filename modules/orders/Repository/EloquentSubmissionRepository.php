<?php


namespace Modules\orders\Repository;


use App\Lib\Jdf;
use App\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Modules\orders\Models\Orders;
use Modules\orders\Models\OrdersSubmission;
use Session;
class EloquentSubmissionRepository extends EloquentBaseRepository implements SubmissionRepositoryInterface
{
    protected $model='Modules\orders\Models\OrdersSubmission';


    public function submission($request,$send_status, $order)
    {
        $string='?';
        $submission=OrdersSubmission::orderBy('order_send_time',$order)->withSum('product','product_count');
        if(inTrashed($request))
        {
            $submission=$submission->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        else{
            $submission=$submission->whereNull('deleted_at');
        }

        if(array_key_exists('submission_id',$request) && !empty($request['submission_id']))
        {
            $submission_id=replace_number2($request['submission_id']);
            $submission=$submission->where('id',$submission_id);
            $string=create_paginate_url($string,'submission_id='.$request['submission_id']);
        }

        if($send_status>=1){
            $submission=$submission->where('send_status',$send_status);
        }
        $submission=$submission->orderBy('id','DESC')->paginate(10);
        $submission->withPath($string);
        return $submission;
    }

    public function trashSubmissionCount($send_status)
    {
        $count=OrdersSubmission::onlyTrashed();
        if($send_status){
            $count=$count->where('send_status',$send_status);
        }
        $count=$count->count();
        return $count;
    }


    public function find($id)
    {
        $relation=['products.product','events.user'];
        $relation=CompleteData('submission_detail_relation',$relation);
        $submission=OrdersSubmission::with($relation)->where(['id'=>$id])->firstOrFail();
        return $submission;
    }

    public function countForUniqueOrder($where,$arrayStatus=[])
    {
        $count=OrdersSubmission::where($where);
        if(sizeof($arrayStatus)>0){
            $count=$count->whereIn('send_status',$arrayStatus);
        }
        $count=$count->distinct()->count('order_id');
        return $count;
    }

    public function getOrder($type)
    {
        $user_id=\Auth::user()->id;
        $status=getStatusFromType($type);
        define('status',$status);

        $orders=Orders::with(['submissions'=>function($query){
            $query->whereIn('send_status',status)->with('products.product');
        }])
            ->whereHas('submissions',function(Builder $query){
                $query->whereIn('send_status',status);
            })->where('user_id',$user_id)->orderBy('id','DESC')
            ->paginate(5);

        return $orders;
    }
}
