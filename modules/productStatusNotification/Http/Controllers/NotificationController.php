<?php

namespace Modules\productStatusNotification\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\productStatusNotification\Models\ProductStatusNotification;
use Modules\setting\Repository\SettingRepositoryInterface;

class NotificationController extends Controller
{
    public function products(Request $request){
        $products=ProductStatusNotification::products($request);
        $req=$request;
        return CView('productStatusNotification::products',compact('products','req'));
    }

    public function setting(SettingRepositoryInterface $repository,Request $request){
        if($request->isMethod('post'))
        {
            $repository->set_data($request->all());
            return  [
                'redirect_url'=>url('admin/notification/product/setting'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        else{
            $data=$repository->get_data([
                'product-notification-channel',
                'product-notification-api-key',
                'product-notification-line-number'
            ]);
        }
        $channels=run_action('sms_channel_info',[],true);

        $channelList=array();
        foreach ($channels as $channel){
            $channelList[$channel['name']]=$channel['title'];
        }
        return CView('productStatusNotification::setting',compact('data','channelList'));
    }
}
