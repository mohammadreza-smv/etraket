<?php

namespace Modules\affiliate\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\affiliate\Http\Requests\AffiliateCommissionRequest;
use Modules\affiliate\Repository\AffiliateCommissionRepositoryInterface;

class AffiliateCommissionController extends CustomController
{
    protected  $title='کمیسیون';

    protected $route_params='affiliate/commissions';

    protected $repository;

    public function __construct(AffiliateCommissionRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request){
        $categories=$this->repository->getCategories();
        $brands=$this->repository->getBrands();;
        $commissions=$this->repository->getList($request);
        $trash_commission_count=$this->repository->trashCount();
        return CView('affiliate::commissions.index',[
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

    public function store(AffiliateCommissionRequest $request){
        if(!$this->repository->checkHas($request)){
            $this->repository->create($request);
            return [
                'redirect_url'=>url('admin/affiliate/commissions'),
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
        return CView('affiliate::commissions.edit',compact('categories','brands','commission'));
    }

    public function update($id,AffiliateCommissionRequest $request){
        $row=$this->repository->checkHas($request);
        if(!$row || $row->id==$id){
            $this->repository->update($id,$request);
            return [
                'redirect_url'=>url('admin/affiliate/commissions'),
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
