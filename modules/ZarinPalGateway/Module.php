<?php

namespace Modules\ZarinPalGateway;
use App\BaseModule;
use DB;
use Modules\orders\Repository\OrdersRepositoryInterface;

class Module extends BaseModule
{
    public function gateway_info(){
        return [
            'title'=>'زرین پال',
            'name'=>'zarin-pal'
        ];
    }

    public function zarin_pal_gateway_request($args){
        $url=url('order/verify');
        $zarinpal=new ZarinPal();
        $code=$zarinpal->pay($args['price'],$url);
        if($code){
            DB::table('orders__list')->where('id',$args['order_id'])->update(
                [
                    'pay_code1'=>$code,
                    'gateway'=>'zarin_pal'
                ]);

            return [
                'header'=>'https://www.zarinpal.com/pg/StartPay/'.$code,
                'status'=>'ok'
            ];
        }
        else{
            DB::table('orders__list')->where('id',$args['order_id'])
                ->update([
                    'pay_status'=>'error_connect',
                    'gateway'=>'zarin_pal'
                ]);
            return [
                'status'=>'error'
            ];
        }
    }

    public function payment_verify(){
        $request=request();
        if($request->has('Authority')){
            $Authority=$request->get('Authority');

            $result=[];
            $orderRepository=app(OrdersRepositoryInterface::class);
            $order=$orderRepository->globalOrderData(['pay_code1'=>$Authority]);
            $result['order']=$order;
            $result['status']='error';

            $zarinpal=new ZarinPal();
            $refId=$zarinpal->verify($order->price,$Authority);

            if($refId) {

                $result['status']='ok';

                DB::table('orders__list')->where('id',$order->id)->update([
                    'pay_status'=>'ok'
                ]);

                DB::table('orders__submission')->where('order_id',$order->id)
                    ->update(['send_status'=>1]);

            }

            return $result;
        }


    }
}
