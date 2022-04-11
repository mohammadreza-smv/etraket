<?php

use Modules\orders\Models\OrdersSubmission;

function get_delivery_order_interval($data){
    if(array_key_exists('sending_order_day',$data)){
        return  $data['sending_order_day']['day_label1'].' تا'.$data['sending_order_day']['day_label2'];
    }
    else{
        return null;
    }
}

function send_order_amount($data){
    $price=0;
    if(array_key_exists('sending_price',$data)){
        if($data['price_type']==0){
            $price=$data['sending_price'];
        }
    }
    return $price;
}

function get_send_amount_type($data){
    $type=0;
    if(array_key_exists('sending_price',$data)){
        $type=$data['price_type'];
    }
    return $type;
}

function add_submission($data,$jdf,$order_id,$user_id,$send_order_data,$submission_key){

    $h=$jdf->tr_num($jdf->jdate('H'));
    $h=(24-$h);

    $sending_time=array_key_exists('sending_time',$data) ? $data['sending_time'] :0;
    settype($sending_time,'integer');
    $time=$sending_time*24*60*60;
    $order_send_time=time()+$time+($h*60*60);

    $delivery_order_interval=get_delivery_order_interval($data);
    $send_order_amount=send_order_amount($data);
    $submission=new OrdersSubmission();
    $submission->order_id=$order_id;
    $submission->delivery_order_interval=$delivery_order_interval;
    $submission->send_order_amount=$send_order_amount;
    $submission->send_status=0;
    $submission->order_send_time=$order_send_time;
    $submission->user_id=$user_id;
    $submission->send_type=get_send_type($send_order_data,$submission_key);
    $submission->send_amount_type=get_send_amount_type($data);
    $submission->save();

    return $submission->id;

}

function add_submission_products($send_order_data,$keys,$submission_id,$send_data){
    $sending_time=array_key_exists('sending_time',$send_data) ? $send_data['sending_time'] :0;
    foreach($keys as $key=>$value){
        $product=$send_order_data['products'][1][$value];
        \Modules\orders\Models\OrderProducts::create([
            'product_id'=>$product->product_id,
            'submission_id'=>$submission_id,
            'param1_type'=>$product->param1_type,
            'param1_id'=>$product->param1_id,
            'param2_type'=>$product->param2_type,
            'param2_id'=>$product->param2_id,
            'price_variation_id'=>$product->id,
            'product_count'=>$product->product_count,
            'product_price1'=>$product->price1,
            'product_price2'=>$product->price2

        ]);
    }
}

function get_order_detail($order){
    $array=[];

    if($order->submissions_count){
        $array[]=[
            'label'=>'تعداد مرسوله:',
            'value'=>replace_number($order->submissions_count)
        ];
    }
    else{
        $array[]=[
            'label'=>'تعداد مرسوله:',
            'value'=>replace_number(sizeof($order->submissions))
        ];
    }

    $array[]=[
        'label'=>'مبلغ قابل پرداخت:',
        'value'=>get_price($order->price)
    ];

    $array[]=[
        'label'=>'مبلغ کل :',
        'value'=>get_price($order->total_price)
    ];

    $array=CompleteData('order_detail',['detail'=>$array,'order'=>$order]);
    return $array['detail'];
}

function set_submission_event($old_status,$status,$order_id,$tozihat,$user_id){
    $event=new \Modules\orders\Models\SubmissionEvents();
    $event->from=$old_status;
    $event->to=$status;
    $event->tozihat=$tozihat;
    $event->user_id=$user_id;
    $event->submission_id=$order_id;
    $event->save();
}

function get_submission_detail($data){

    if($data->send_amount_type==0){
        $send_order_amount=get_price($data->send_order_amount);
    }
    else if($data->send_amount_type==1){
        $send_order_amount='پس کرایه';
    }

    $array=[];

    $array[]=[
        'label'=>' زمان تحویل:',
        'value'=>$data->delivery_order_interval
    ];

    $array[]=[
        'label'=>'نحوه ارسال:',
        'value'=>$data->send_type
    ];

    $array[]=[
        'label'=>'هزینه ارسال:',
        'value'=>$send_order_amount
    ];

    $array[]=[
        'label'=>'مبلغ مرسوله:',
        'value'=>get_submission_price($data)
    ];

    $array=CompleteData('submission_detail',['detail'=>$array,'data'=>$data]);
    return $array['detail'];
}

function get_submission_price($submission){
    $price=0;
    foreach ($submission->products as $product){
        $price=$price+($product->product_count*$product->product_price2);
    }
    return get_price($price);
}

function get_send_type($data,$key){
    $title=0;
    if(array_key_exists('send_methods',$data)){
        if(array_key_exists($key,$data['send_methods'])){
            $title=$data['send_methods'][$key]['title'];
        }
    }
    return $title;
}

function orderChartData(){

    $jdf=new \App\Lib\Jdf();
    $date=$jdf->tr_num($jdf->jdate('Y/n')).'/1';
    $time=getTimestamp($date,'first');

    $y=$jdf->tr_num($jdf->jdate('Y'));
    $m=$jdf->tr_num($jdf->jdate('n'));
    $t=$jdf->tr_num($jdf->jdate('t'));

    $date_list=array();
    $price_array=array();
    $count_array=array();

    for($i=0;$i<$t;$i++){
        $d=$y.'-'.$m.'-'.($i+1);
        $date_list[$i]=$d;
    }

    $orders=\Modules\orders\Models\Orders::where(['pay_status'=>'ok'])->where('created_at','>=',$time)
        ->get();

    foreach($orders as $order){
        if(array_key_exists($order->date,$price_array)){
            $price_array[$order->date]= $price_array[$order->date]+$order->price;
            $count_array[$order->date]=$count_array[$order->date]+1;
        }
        else{
            $price_array[$order->date]=$order->price;
            $count_array[$order->date]=1;
        }
    }

    foreach($date_list as $key=>$value){
        if(!array_key_exists($value,$price_array)){
            $price_array[$key]=0;
            $count_array[$key]=0;
        }
        else{
            $price_array[$key]=$price_array[$value];
            $count_array[$key]=$count_array[$value];
            unset($price_array[$value]);
            unset($count_array[$value]);
        }
    }

    return [
        'price_array'=>$price_array,
        'count_array'=>$count_array,
        'date_list'=>$date_list
    ];
}

function getStatusFromType($type){
    $status=[];
    $types=user_panel_submission_types();
    if(array_key_exists($type,$types)){
        $status= $types[$type]['value'];
    }
    return $status;
}


function submissionsTitle():array
{
    $array=array();
    $array[1]='مرسوله های تایید شده';
    $array[2]='مرسوله های در حال آماده سازی';
    $array[3]='مرسوله های خارج شده از مرکز پردازش';
    $array[4]='مرسوله های تحویل داده شده به پست';
    $array[5]='مرسوله های دریافت شده امرکز مبادلات پست';
    $array[6]='مرسوله های تحویل داده شده به مشتری';
    return CompleteData('submissions_title',$array);
}

function getOrderStatus($value){
    $status='';
    $statusList=\Modules\orders\Models\Orders::OrderStatus();
    foreach ($statusList as $array){
        if($array['value']==$value){
            $status=$array['title'];
        }
    }
    return $status;
}

function user_panel_submission_types(){
    $array=[];
    $array['wait_for_payment']=['title'=>'در انتظار پرداخت','value'=>[0]];
    $array['paid_in_progress']=['title'=>'در حال پردازش','value'=>[1,2,3,4,5]];
    $array['delivered']=['title'=>'تحویل شده','value'=>[6]];
    $array['returned']=['title'=>'مرجوعی','value'=>[-1]];
    $array['canceled']=['title'=>'لغو شده','value'=>[-2]];
    return CompleteData('user_panel_submission_types',$array);
}
