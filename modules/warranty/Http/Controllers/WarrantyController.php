<?php

namespace Modules\warranty\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use App\Warranty;
use Illuminate\Http\Request;
use Modules\warranty\Repository\WarrantyRepositoryInterface;

class WarrantyController extends CustomController
{
    protected $title='گارانتی';
    protected $route_params='warranties';
    protected $repository;
    public function __construct(WarrantyRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $warranty=$this->repository->getList($request);
        $trash_warranty_count=$this->repository->trashCount();
        return CView('warranty::index',['warranty'=>$warranty,'trash_warranty_count'=>$trash_warranty_count,'req'=>$request]);
    }
    public function create()
    {
        return CView('warranty::create');
    }
    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required'],[],['name'=>'نام گارانتی']);
        $this->repository->create($request);

        return  [
            'redirect_url'=>url('admin/warranties'),
            'message'=>'ثبت گارانتی با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $warranty=$this->repository->find($id);
        return CView('warranty::edit',['warranty'=>$warranty]);
    }

    public function update($id,Request $request)
    {
        $this->validate($request,['name'=>'required'],[],['name'=>'نام گارانتی']);
        $this->repository->update($id,$request);

        return  [
            'redirect_url'=>url('admin/warranties'),
            'message'=>'ویرایش گارانتی با موفقیت انجام شد'
        ];
    }
}
