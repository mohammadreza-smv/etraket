<?php


namespace Modules\orders\Repository;

use App\Lib\Jdf;
use App\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Modules\orders\Models\OrderProducts;
use Modules\orders\Models\Orders;
use Modules\orders\Models\OrdersSubmission;
use Session;
class EloquentOrdersRepository extends EloquentBaseRepository implements OrdersRepositoryInterface
{
    protected $model='Modules\orders\Models\Orders';

    public function find($id)
    {
        $relation=['submissions.products.product','submissions.events.user'];
        $relation=CompleteData('order_detail_relation',$relation);
        $order=Orders::with($relation)->where(['id'=>$id])->firstOrFail();
        if( $order->order_read=='no' && \Auth::user()->role=='admin'){
            $order->order_read='ok';
            $order->update();
        }
        return $order;
    }

    public function create($request)
    {

    }

    public function trashCount()
    {
        return Orders::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Orders::getData($request->all());
    }

    public function update($id, $request)
    {
        // TODO: Implement update() method.
    }

    public function add_order($user_id,$send_order_data)
    {
        $jdf=new Jdf();
        $time=time();
        $order_code=substr($time,1,5).$user_id.substr($time,5,10);
        $date=$jdf->tr_num($jdf->jdate('Y-n-j'));
        $total_price=$send_order_data['total_price'][1];
        DB::beginTransaction();
        try{
            $send_type=defined('send_type') ? send_type : Session::get('order_send_type');
            $price=$send_order_data['final_price'][1][$send_type];
            $data=[
                'user_id'=>$user_id,
                'address_id'=>address_id,
                'order_id'=>$order_code,
                'order_read'=>'no',
                'pay_status'=>'awaiting_payment',
                'date'=>$date,
                'send_type'=>$send_type,
                'total_price'=>$total_price,
                'price'=>$price,
            ];
            $data=CompleteData('before_add_order',$data);
            $order=new Orders($data);
            $order->save();
            $this->add_order_submissions($send_order_data,$user_id,$send_type,$order->id,$jdf);
            DB::commit();

            return [
                'status'=>'ok',
                'order_id'=>$order->id,
                'price'=>$order->price
            ];

        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return [
                'status'=>'error',
            ];
        }
    }

    protected function add_order_submissions($send_order_data,$user_id,$send_type,$order_id,$jdf){
        foreach($send_order_data['product_with_sending_type'][1][$send_type] as $key=>$value)
        {
            foreach($value as $key2=>$value2){

                if($key2=='product_key'){
                    $submission_id=add_submission([],$jdf,$order_id,$user_id,$send_order_data,$key);
                    add_submission_products($send_order_data,$value2,$submission_id,[]);
                }
                else{
                    foreach($value2 as $key3=>$value3){
                        if($key3=='product_key'){
                            $submission_id=add_submission($value2,$jdf,$order_id,$user_id,$send_order_data,$key2);
                            add_submission_products($send_order_data,$value3,$submission_id,$value2);
                        }
                    }
                }
            }
        }
    }

    public function change_submission_state($request)
    {
        $submission_id=$request->get('order_id');
        $status=$request->get('status');
        $tozihat=$request->get('tozihat');
        $user_id=\Auth::user()->id;
        $submission=OrdersSubmission::where('id',$submission_id)->first();
        if($submission){
            DB::beginTransaction();
            $old_status=$submission->send_status;
            $submission->send_status=$status;
            try{
                $submission->update();
                OrderProducts::where('submission_id',$submission_id)
                    ->update(['send_status'=>$status]);
                set_submission_event($old_status,$status,$submission_id,$tozihat,$user_id);
                DB::commit();
                return 'success';
            }
            catch (\Exception $exception){
                DB::rollBack();
                return 'error';
            }
        }
        else{
            return 'error';
        }
    }

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

    public function trashSubmissionCount($status)
    {
        $count=Orders::onlyTrashed();
        if($status){
            $count=$count->where('send_status',$status);
        }
        $count=$count->count();
        return $count;
    }

    public function userLastOrder($where)
    {
        return Orders::where($where)->orderBy('id','DESC')->limit(10)->get();
    }

    public function userOrder($where)
    {
        $relation=['submissions.products.product'];
        $relation=CompleteData('order_detail_relation',$relation);
        $order=Orders::with($relation)->where($where)->firstOrFail();
        return $order;
    }

    public function globalOrderData($where)
    {
        $relation=[];
        $relation=CompleteData('order_detail_relation',$relation);
        return Orders::with($relation)->withCount('submissions')->where($where)->firstOrFail();
    }

    public function ordersWithSendStatus($status,$where)
    {
        $user_id=\Auth::guard('api')->user()->id;
        define('status',$status);
        $orders=Orders::with(['submissions'=>function($query){
            $query->where('send_status',status)->with('products.product');
        }])->whereHas('submissions',function(Builder $query){
            $query->where('send_status',status);
        })->where('user_id',$user_id)
            ->orderBy('id','DESC')
            ->paginate(10);

        return $orders;
    }
}
