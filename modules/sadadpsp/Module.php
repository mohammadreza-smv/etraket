<?php

namespace Modules\sadadpsp;

use App\BaseModule;
use Modules\orders\Repository\OrdersRepositoryInterface;
use Modules\sadadpsp\Model\Sadad;

class Module extends BaseModule
{
    public function gateway_info(){
        return [
            'title'=>'سداد',
            'name'=>'sadadpsp'
        ];
    }

    public function sadadpsp_gateway_request($args){
        $url=url('order/verify');
        $sadad=new Sadad();
        $token=$sadad->pay($args['price'],$args['order_id'],$url);
        if($token){
            DB::table('orders__list')->where('id',$args['order_id'])->update(
                [
                    'pay_code1'=>$token,
                    'gateway'=>'sadadpsp'
                ]);

            return [
                'header'=>'https://sadad.shaparak.ir/VPG/Purchase?Token='.$token,
                'status'=>'ok'
            ];
        }
        else{
            DB::table('orders__list')->where('id',$args['order_id'])
                ->update([
                    'pay_status'=>'error_connect',
                    'gateway'=>'sadadpsp'
                ]);
            return [
                'status'=>'error'
            ];
        }
    }

    public function payment_verify(){
        $request=request();
        if($request->has('token') && $request->has('OrderId') && $request->has('ResCode'))
        {
            $token=$request->get('token');

            $result=[];
            $orderRepository=app(OrdersRepositoryInterface::class);
            $order=$orderRepository->globalOrderData(['pay_code1'=>$token]);
            $result['order']=$order;
            $result['status']='error';

            $sadad=new Sadad();
            $ResCode=$request->get('ResCode');
            $res=$sadad->verify($order->price,$token,$ResCode);

            if($res['status']=='ok') {

                $result['status']='ok';

                DB::table('orders__list')->where('id',$order->id)->update([
                    'pay_status'=>'ok',
                    'pay_code2'=>$res['SystemTraceNo'],
                ]);

                DB::table('orders__submission')->where('order_id',$order->id)
                    ->update(['send_status'=>1]);

            }

            return $result;

        }
    }
}
