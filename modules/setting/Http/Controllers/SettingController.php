<?php


namespace Modules\setting\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\setting\Models\Setting;
use Modules\setting\Repository\SettingRepositoryInterface;

class SettingController extends Controller
{
    public function shop(Request $request)
    {
        if($request->isMethod('post'))
        {
            $setting=new Setting();
            $setting->addConfig($request);

            return  [
                'redirect_url'=>url('admin/setting/shop'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        return CView('setting::shop');
    }

    public function payment_gateway(SettingRepositoryInterface $repository,Request $request){
        if($request->isMethod('post'))
        {
            $setting=new Setting();
            $setting->addGatewayConfig($request);
            return  [
                'redirect_url'=>url('admin/setting/payment-gateway'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        return CView('setting::payment_gateway');
    }
}
