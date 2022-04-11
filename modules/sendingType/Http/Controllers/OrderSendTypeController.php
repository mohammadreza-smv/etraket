<?php

namespace Modules\sendingType\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\sendingType\Http\Requests\SendingTypeRequest;
use Modules\sendingType\Repository\SendingTypeRepositoryInterface;

class OrderSendTypeController extends CustomController
{
    protected  $title='نوع ارسال مرسوله';

    protected $route_params='setting/sending_type';

    protected $repository;

    public function __construct(SendingTypeRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $send_types=$this->repository->getList($request);
        $trash_send_types_count=$this->repository->trashCount();
        return CView('sendingType::index',['send_types'=>$send_types,'trash_send_types_count'=>$trash_send_types_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('sendingType::create');
    }

    public function store(SendingTypeRequest $request)
    {
        $result=$this->repository->create($request);
        if($result){
            return  [
                'redirect_url'=>url('admin/setting/sending_type'),
                'message'=>'ثبت نوع ارسال با موفقیت انجام شد',
            ];
        }
    }

    public function edit($id){
        $send_type=$this->repository->find($id);
        return CView('sendingType::edit',['send_type'=>$send_type]);
    }

    public function update($id,SendingTypeRequest $request)
    {
        $result=$this->repository->update($id,$request);

        if($result){
            return  [
                'redirect_url'=>url('admin/setting/sending_type'),
                'message'=>'ویرایش نوع ارسال با موفقیت انجام شد',
            ];
        }
    }
}
