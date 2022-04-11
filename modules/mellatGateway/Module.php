<?php

namespace Modules\mellatGateway;

use App\BaseModule;
use Modules\orders\Repository\OrdersRepositoryInterface;
use DB;

class Module extends BaseModule
{
    public function gateway_info(){
        return [
            'title'=>'بانک ملت',
            'name'=>'mellat'
        ];
    }

    public function mellat_gateway_request($args){
        require_once base_path('app/Lib/nusoap.php');
        if(array_key_exists('price',$args)){
            $mellat_bank=new MellatBank();
            $callBackUrl=array_key_exists('callBackUrl',$args) ? $args['callBackUrl'] : url('order/verify');
            $refId=$mellat_bank->pay($args['price'],$args['order_id'],$callBackUrl);
            if($refId){

                DB::table('orders__list')->where('id',$args['order_id'])->update([
                    'pay_code1'=>$refId,
                    'gateway'=>'mellat'
                ]);

                return [
                    'view'=>'mellatGateway::request',
                    'params'=>[
                        'res'=>$refId
                    ],
                    'status'=>'ok'
                ];

            }
            else{
                DB::table('orders__list')
                    ->where('id',$args['order_id'])
                    ->update([
                        'pay_status'=>'error_connect',
                        'gateway'=>'mellat'
                    ]);
                return  [
                    'status'=>'error',
                ];
            }
        }
        else{
            return  [
                'status'=>'error',
            ];
        }

    }

    public function payment_verify(){

        $request=request();

        if($request->has('RefId') && $request->has('SaleReferenceId')){
            $RefId=$request->get('RefId',0);
            $ResCode=$request->get('ResCode');
            $SaleOrderId=$request->get('SaleOrderId');
            $SaleReferenceId=$request->get('SaleReferenceId');

            $result=[];
            $orderRepository=app(OrdersRepositoryInterface::class);
            $order=$orderRepository->globalOrderData(['pay_code1'=>$RefId]);
            $result['order']=$order;
            $result['status']='error';

            if($request->has('ResCode') && $ResCode==0 )
            {
                require  base_path('app/Lib/nusoap.php');

                $mellat_bank=new MellatBank();
                if($mellat_bank->Verify($SaleOrderId,$SaleReferenceId)){

                    $result['status']='ok';

                    DB::table('orders__list')->where('id',$order->id)->update([
                        'pay_code2'=>$SaleReferenceId,
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
