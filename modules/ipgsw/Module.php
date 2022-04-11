<?php


namespace Modules\ipgsw;

use App\BaseModule;
use DB;
use Modules\ipgsw\Models\IPGSW;
use Modules\orders\Repository\OrdersRepositoryInterface;

class Module extends BaseModule
{
    public function gateway_info(){
        return [
            'title'=>'پارسیان',
            'name'=>'ipgsw'
        ];
    }

    public function mellat_gateway_request($args){
        $IPGSW=new IPGSW();
        $callBackUrl=array_key_exists('callBackUrl',$args) ? $args['callBackUrl'] : url('order/verify');
        $token=$IPGSW->pay($args['price'],$args['order_id'],$callBackUrl);
        if($token){

            DB::table('orders__list')->where('id',$args['order_id'])->update([
                'pay_code1'=>$token,
                'gateway'=>'ipgsw'
            ]);

            return [
                'header'=>'https://pec.shaparak.ir/NewIPG/?Token='.$token,
                'status'=>'ok'
            ];
        }
        else{
            DB::table('orders__list')->where('id',$args['order_id'])->update(['pay_status'=>'error_connect']);
            return  [
                'status'=>'error'
            ];
        }

    }

    public function payment_verify(){

        $request=request();

        if($request->has('Token') && $request->has('TerminalNo')){

            $Token=$request->get('Token');
            $status=$request->get('status');
            $OrderId=$request->get('OrderId');
            $TerminalNo=$request->get('TerminalNo');
            $Amount=$request->get('Amount');
            $RRN=$request->get('RRN');

            $result=[];
            $orderRepository=app(OrdersRepositoryInterface::class);
            $order=$orderRepository->globalOrderData(['pay_code1'=>$Token]);
            $result['order']=$order;
            $result['status']='error';

            if ($RRN > 0 && $status == 0 && $request->has('RRN'))
            {
                $IPGSW=new IPGSW();
                if($IPGSW->Verify($Token,$status,$OrderId,$TerminalNo,$Amount,$RRN)){

                    $result['status']='ok';

                    DB::table('orders__list')->where('id',$order->id)->update([
                        'pay_status'=>'ok'
                    ]);

                    DB::table('orders__submission')->where('order_id',$order->id)
                        ->update(['send_status'=>1]);
                }
            }
            return $result;
        }
    }
}
