<?php


namespace Modules\orders\Models;


use App\CustomModel;
use App\Lib\Jdf;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends CustomModel
{
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $table='orders__list';

    protected $guarded=[];

    public static function getData($request)
    {
        $string='?';
        $orders=self::orderBy('id','DESC');
        if(inTrashed($request))
        {
            $orders=$orders->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('user_id',$request) && !empty($request['user_id']))
        {
            $orders=$orders->where('user_id',$request['user_id']);
            $string=create_paginate_url($string,'user_id='.$request['user_id']);
        }
        if(array_key_exists('order_id',$request) && !empty($request['order_id']))
        {
            $order_id=replace_number2($request['order_id']);
            $orders=$orders->where('order_id',$order_id);
            $string=create_paginate_url($string,'order_id='.$request['order_id']);
        }
        if(array_key_exists('first_date',$request) && !empty($request['first_date']))
        {
            $first_date=getTimestamp($request['first_date'],'first');
            $orders=$orders->where('created_at','>=',$first_date);
            $string=create_paginate_url($string,'first_date='.$request['first_date']);
        }
        if(array_key_exists('end_date',$request) && !empty($request['end_date']))
        {
            $end_date=getTimestamp($request['end_date'],'end');
            $orders=$orders->where('created_at','<=',$end_date);
            $string=create_paginate_url($string,'end_date='.$request['end_date']);
        }
        $orders=$orders->paginate(10);
        $orders->withPath($string);
        return $orders;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value;
    }

    public function submissions(){
        return $this->hasMany(OrdersSubmission::class,'order_id','id');
    }

    public static function OrderStatus()
    {
        $array=array();
        $array[]=['value'=>-2,'title'=>'خطا در اتصال به درگاه'];
        $array[]=['value'=>-1,'title'=>'لغو شده'];
        $array[]=['value'=>0,'title'=>'در انتظار پرداخت'];
        $array[]=['value'=>1,'title'=>'تایید سفارش'];
        $array[]=['value'=>2,'title'=>'آماده سازی سفارش'];
        $array[]=['value'=>3,'title'=>'خروج از مرکز پردازش'];
        $array[]=['value'=>4,'title'=>'تحویل به پست'];
        $array[]=['value'=>5,'title'=>'دریافت از مرکز مبادلات پست'];
        $array[]=['value'=>6,'title'=>'تحویل مرسوله به مشتری'];
        $array=CompleteData('order_status_list',$array);
        return $array;
    }

    public function getPriceAttribute($value)
    {
          $routeName=getRouteName();
          if($routeName=='userpanel_order'){
              return  get_price($value);
          }
          else{
              return $value;
          }
    }

}
