<?php


namespace Modules\sadadpsp\Http\Controllers;


use Illuminate\Http\Request;
use Modules\setting\Repository\SettingRepositoryInterface;

class GatewayController
{
    public function setting(SettingRepositoryInterface $repository,Request $request){
        if($request->isMethod('post'))
        {
            $data=$repository->set_data($request->all());
            return  redirect()->back();
        }
        else{
            $data=$repository->get_data(['sadad_merchantId','sadad_terminalId','sadad_terminalKey']);
        }
        return CView('sadadpsp::setting',['data'=>$data]);
    }
}
