<?php


namespace Modules\sendingType\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\sendingType\Http\Requests\SettingRequest;
use Modules\sendingType\Models\SendingType;
use Modules\setting\Repository\SettingRepositoryInterface;

class SettingController extends Controller
{
    public function send_order_price(SettingRequest $request,SettingRepositoryInterface $repository)
    {
        $send_types=SendingType::get();
        if($request->isMethod('post'))
        {
            $data=$repository->set_data($request->all());
            return redirect()->back();
        }
        else{
            $data=$repository->get_data(get_send_type_field($send_types));
        }
        return CView('sendingType::send_order_price',['data'=>$data,'send_types'=>$send_types]);
    }
}
