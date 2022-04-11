<?php


namespace Modules\orders\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\orders\Repository\OrdersRepositoryInterface;

class ApiController extends Controller
{
    public function order_list($type,Request $request,OrdersRepositoryInterface $ordersRepository){
        $user_id=$request->user()->id;
        $status=[];
        if($type=="progress"){
            $status=[1,2,3,4,5];
        }
        if($type=="wait_for_payment"){
            $status=[0];
        }
        return $ordersRepository->ordersWithSendStatus($status,[
            'user_id'=>$user_id
        ]);
    }

    public function order_content($id,OrdersRepositoryInterface $ordersRepository,Request $request){
        $user_id=$request->user()->id;
        return $order=$ordersRepository->userOrder([
            'id'=>$id,
            'user_id'=>$user_id
        ]);
    }
}
