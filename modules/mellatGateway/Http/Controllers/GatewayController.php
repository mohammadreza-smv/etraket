<?php


namespace Modules\mellatGateway\Http\Controllers;


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
                'redirect_url'=>url('admin/setting/gateway/mellat'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        else{
            $data=$repository->get_data(['TerminalId','Username','Password']);
        }
        return CView('mellatGateway::setting',['data'=>$data]);
    }
}
