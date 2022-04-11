<?php

use Modules\sellers\Models\SellerFollowers;
use Modules\sellers\Models\SellerProduct;

function validateMobileNumber($value){
    settype($value, 'integer');
    if (strlen($value) == 10 && is_numeric($value) && substr($value, 0, 1) == "9") {
        return true;
    } else {
        return  false;
    }
}

function send_sms_to_seller($seller,$mobile,$message,$template)
{
    $repository=app(\Modules\setting\Repository\SettingRepositoryInterface::class);
    $settings=$repository->getValues(['sellers-channel','sellers-line_number','sellers-api-key',$template]);


    $seller->notify(new \Modules\setting\Notifications\SendSms(
        [
            'channel'=>$settings['sellers-channel'],
            'line_number'=>$settings['sellers-line_number'],
            'api-key'=>$settings['sellers-api-key'],
            'template'=>$settings[$template],
            'mobile_number'=>$mobile,
            'message'=>$message
        ]
    ));
}

function getSellerPanelMenu(){
    $list=[];

    $list[]=[
        'label'=>'محصولات',
        'icon'=>'mdi-basket',
        'child'=>[
            ['label'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
            ['label'=>'افزودن محصول جدید','url'=>url('sellers/panel/products/create')],
            ['label'=>'محصولات فروشگاه','url'=>url('sellers/panel/products/total/show')]
        ]
    ];

    $list[]=[
        'label'=>'سفارشات',
        'icon'=>'mdi-cart',
        'child'=>[
            ['label'=>'مدیریت سفارشات','url'=>url('sellers/panel/orders')],
            ['label'=>'محصولات قابل ارسال','url'=>'']
        ]
    ];

    $list[]=[
        'icon'=>'mdi-paypal',
        'label'=>'آمار فروش',
        'child'=>[
            ['label'=>'مدیریت پرداخت ها','url'=>url('sellers/panel/payment')],
        ]
    ];

    $list[]=[
        'icon'=>'mdi-android-messages',
        'label'=>'پیام ها',
        'url'=>url('sellers/panel/messages')
    ];

    $list[]=[
        'icon'=>'mdi-cogs',
        'label'=>'تنظیمات',
        'child'=>[
            ['label'=>'پروفایل','url'=>url('sellers/panel/profile')],
        ]
    ];

    return $list;
}

function get_seller_id(){
    return \Auth::guard('seller')->user()->id;
}

function add_seller_document($request,$seller_id,$file_name)
{
    $image_url=upload_file($request,$file_name,'seller',$file_name.'_');
    if($image_url)
    {
        $check=DB::table('seller_document')->where('seller_id',$seller_id)->first();
        if($check && !empty($check->$file_name))
        {
            if(file_exists('files/seller/'.$check->$file_name)){
                unlink('files/seller/'.$check->$file_name);
            }
            DB::table('seller_document')->where(['seller_id'=>$seller_id])->update([
                $file_name=>$image_url
            ]);
        }
        else{
            DB::table('seller_document')
                ->insert(['seller_id'=>$seller_id,$file_name=>$image_url]);
        }
        return true;
    }
    else{
        if($request->hasFile($file_name))
        {
            return false;
        }
        else{
            return true;
        }
    }
}

function sellerLastTimeOnline($timeStamp){
    $t=time()-$timeStamp;
    $y=$t/31536000;
    $m=$t/2592000;
    $w=$t/604800;
    $d=$t/86400;
    $h=$t/3600;
    $mi=$t/60;
    if(intval($y)>0){
        return replace_number(intval($y)).' سال پیش';
    }
    elseif (intval($m)>0){
        return replace_number(intval($m)).' ماه پیش';
    }
    elseif (intval($w)>0){
        return replace_number(intval($w)).' هفته پیش';
    }
    elseif (intval($d)>0){
        return replace_number(intval($d)).' روز پیش';
    }
    elseif (intval($h)>0){
        return replace_number(intval($h)).' ساعت پیش';
    }
    elseif (intval($mi)>0){
        return replace_number(intval($mi)).' دقیقه پیش';
    }
    else{
        return  'لحظاتی پیش';
    }
}

function get_search_followed_products_query($query){
    if(\Auth::check()){
        $user_id=\Auth::user()->id;
        $sellers=SellerFollowers::where('user_id',$user_id)
            ->get();
        $productData=[];
        $productsId=[];
        foreach ($sellers as $value){
            $productData=$productData+SellerProduct::where('seller_id',$value->seller_id)
                    ->where('created_at','>=',$value->time)
                    ->get()->toArray();
        }

        foreach ($productData as $value){
            $productsId[$value['product_id']]=$value['product_id'];
        }

        return $query->whereIn('id',$productsId);
    }
    else{
        return $query;
    }
}
