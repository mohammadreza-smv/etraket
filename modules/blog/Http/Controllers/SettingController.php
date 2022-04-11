<?php

namespace Modules\blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\blog\Models\Domain;

class SettingController extends Controller
{
    public function domain(Request $request){
        if($request->isMethod('post'))
        {
            \Log::info(var_export($request->all(),true));
            $setting=new Domain();
            $setting->addConfig($request);

            return  [
                'redirect_url'=>url('admin/blog/domain'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        return CView('blog::domain');
    }
}
