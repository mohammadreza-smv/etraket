<?php


namespace Modules\orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\address\Repository\AddressRepositoryInterface;
use Modules\orders\Repository\OrdersRepositoryInterface;
use Modules\orders\Repository\SubmissionRepositoryInterface;
use Modules\users\Repository\AdditionalInfoRepositoryInterface;

class UserPanelController extends Controller
{
    public function orders(Request $request,SubmissionRepositoryInterface $submissionRepository){

        $user_id=$request->user()->id;
        $activeTab=$request->get('activeTab','wait_for_payment');

        $delivered=$submissionRepository->countForUniqueOrder([
            'user_id'=>$user_id,
            'send_status'=>6
        ]);

        $wait_for_payment=$submissionRepository->countForUniqueOrder([
            'user_id'=>$user_id,
            'send_status'=>0
        ]);

        $paid_in_progress=$submissionRepository->countForUniqueOrder([
            'user_id'=>$user_id,
        ],[1,2,3,4,5]);

        $returned=$submissionRepository->countForUniqueOrder([
            'user_id'=>$user_id,
            'send_status'=>-1
        ]);

        $canceled=$submissionRepository->countForUniqueOrder([
            'user_id'=>$user_id,
            'send_status'=>-2
        ]);
        $orders=$submissionRepository->getOrder($activeTab,$user_id);

        config()->set('view.orders_component','add');

        return CView('orders::userpanel.'.$this->view.'.list',compact(
            'delivered',
            'wait_for_payment',
              'paid_in_progress',
              'returned',
              'canceled',
              'orders',
              'activeTab'
        ));
    }

    public function json_orders(Request $request,SubmissionRepositoryInterface $submissionRepository){
        $activeTab=$request->get('activeTab','wait_for_payment');
        return $submissionRepository->getOrder($activeTab);
    }

    public function show_order($id,OrdersRepositoryInterface $ordersRepository){
        config()->set('view.orders_component','add');
        $user_id=\Auth::user()->id;
        $order=$ordersRepository->userOrder([
            'id'=>$id,
            'user_id'=>$user_id
        ]);
        return CView('orders::userpanel.'.$this->view.'order-detail',compact('order'));
    }

    public function order_factor($id,OrdersRepositoryInterface $repository){
        $user=null;
        $address=null;
        $user_id=\Auth::user()->id;
        $order=$repository->userOrder([
            'id'=>$id,
            'user_id'=>$user_id,
            'pay_status'=>'ok'
        ]);
        if(interface_exists(AdditionalInfoRepositoryInterface::class)){
            $userRepository=app(AdditionalInfoRepositoryInterface::class);
            $user=$userRepository->find([
                'user_id'=>$user_id
            ]);
        }

        if(interface_exists(AddressRepositoryInterface::class)){
            $addressRepository=app(AddressRepositoryInterface::class);
            $address=$addressRepository->first([
                'id'=>$order->address_id
            ],true);
        }

        return CView('orders::factor.view',compact('order','user','address'));
    }
}
