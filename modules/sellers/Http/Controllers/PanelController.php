<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\sellers\Http\Requests\ProfileRequest;
use Modules\sellers\Repository\ApiRepositoryInterface;

class PanelController extends Controller
{
    protected $repository;

    public function __construct(ApiRepositoryInterface $repository)
    {
        $this->repository=$repository;
        config()->set('view.build_component','add');
        parent::__construct();
    }

    public function index(Request $request){
        $latsOrders=$this->repository->orders($request);
        $seller=\Auth::guard('seller')->user();
        return CView('sellers::panel.index',compact('latsOrders','seller'));
    }

    public function logout(){
        Auth::guard('seller')->logout();
        return [
            'reload'=>url('sellers/login')
        ];
    }

    public function orders(Request $request){
        $orders=$this->repository->orders($request);
        return CView('sellers::panel.orders.index',[
            'orders'=>$orders,
            'req'=>$request
        ]);
    }

    public function profile(){

        $seller=Auth::guard('seller')->user();
        return CView('sellers::panel.profile',
            compact('seller'));
    }

    public function edit_profile($id,ProfileRequest $request){
         return $this->repository->edit_profile($request);
    }

    public function profile_active_code(Request $request){
        return $this->repository->profile_active_code($request);
    }

    public function payment(Request $request){

        $payment=$this->repository->seller_payment($request);

        return CView('sellers::panel.statistics.payment',
            compact('payment'));
    }

    public function show_order_content($id,Request $request){
        $order=$this->repository->order_content($id);
        return CView('sellers::panel.orders.show',[
            'order'=>$order,
            'id'=>$id
        ]);
    }
}
