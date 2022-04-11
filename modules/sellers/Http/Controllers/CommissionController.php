<?php

namespace Modules\sellers\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\sellers\Http\Requests\CommissionRequest;
use Modules\sellers\Repository\CommissionRepositoryInterface;

class CommissionController extends CustomController
{
    protected  $title='کمیسیون';

    protected $route_params='sellers/commissions';

    protected $repository;

    public function __construct(CommissionRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request){
        $categories=$this->repository->getCategories();
        $brands=$this->repository->getBrands();;
        $commissions=$this->repository->getList($request);
        $trash_commission_count=$this->repository->trashCount();
        return CView('sellers::commissions.index',[
            'commissions'=>$commissions,
            'trash_commission_count'=>$trash_commission_count,
            'req'=>$request,
            'categories'=>$categories,
            'brands'=>$brands,
        ]);
    }

    public function create()
    {
        $categories=$this->repository->getCategories();
        $brands=$this->repository->getBrands();
        return CView('sellers::commissions.create',compact('categories','brands'));
    }

    public function store(CommissionRequest $request){
        if(!$this->repository->checkHas($request)){
            $this->repository->create($request);
            return [
                'redirect_url'=>url('admin/sellers/commissions'),
                'message'=>'ثبت کمیسون با موفقیت انجام شد'
            ];
        }
        else{
            return  [
                'status'=>'error',
                'message'=>'برای دسته و برند انتخاب شده قبلا درصد کمیسیون ثبت شده'
            ];
        }
    }

    public function edit($id)
    {
        $commission=$this->repository->find($id);
        $categories=$this->repository->getCategories();
        $brands=$this->repository->getBrands();
        return CView('sellers::commissions.edit',compact('categories','brands','commission'));
    }

    public function update($id,CommissionRequest $request){
        $row=$this->repository->checkHas($request);
        if(!$row || $row->id==$id){
            $this->repository->update($id,$request);
            return [
                'redirect_url'=>url('admin/sellers/commissions'),
                'message'=>'ویرایش کمیسون با موفقیت انجام شد'
            ];
        }
        else{
            return  [
                'status'=>'error',
                'message'=>'برای دسته و برند انتخاب شده قبلا درصد کمیسیون ثبت شده'
            ];
        }
    }
}
