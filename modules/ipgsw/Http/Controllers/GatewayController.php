<?php


namespace Modules\ipgsw\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\setting\Repository\SettingRepositoryInterface;

class GatewayController extends Controller
{
    public function setting(SettingRepositoryInterface $repository,Request $request){
        if($request->isMethod('post'))
        {
            $data=$repository->set_data($request->all());
            return  [
                'redirect_url'=>url('admin/setting/gateway/ipgsw'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        else{
            $data=$repository->get_data(['PIN']);
        }
        return CView('ipgsw::setting',['data'=>$data]);
    }
}
