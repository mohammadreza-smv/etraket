<?php


namespace Modules\orders\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\address\Repository\AddressRepositoryInterface;
use Modules\orders\Repository\OrdersRepositoryInterface;
use Modules\orders\Repository\SubmissionRepositoryInterface;
use Modules\users\Repository\AdditionalInfoRepositoryInterface;

class OrdersController extends CustomController
{
    protected $title='سفارشات';

    protected $route_params='orders';

    protected $repository;

    public function __construct(OrdersRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $orders=$this->repository->getList($request);
        $trash_orders_count=$this->repository->trashCount();
        return CView('orders::index',[
            'orders'=>$orders,'trash_orders_count'=>$trash_orders_count,'req'=>$request
        ]);
    }

    public function show($id){
        $order=$this->repository->find($id);
        return CView('orders::show',compact('order'));
    }

    public function change_status(Request $request){
       $status=$this->repository->change_submission_state($request);
       $message=$status==='error' ? 'خطا در اجرای درخواست' : 'تغییر وضعیت مرسوله انجام شد';
       return [
           'redirect_url'=>\URL::previous(),
           'status'=>$status,
           'message'=>$message
       ];
    }

    public function factor($id){

        $user=null;
        $address=null;
        $order=$this->repository->userOrder([
            'id'=>$id,
            'pay_status'=>'ok'
        ]);
        if(interface_exists(AdditionalInfoRepositoryInterface::class)){
            $userRepository=app(AdditionalInfoRepositoryInterface::class);
            $user=$userRepository->find([
                'user_id'=>$order->user_id
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

    public function index_chart_data(){
        return orderChartData();
    }
}
