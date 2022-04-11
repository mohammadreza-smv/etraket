<?php

namespace Modules\brands\Http\Controllers;

use App\Brand;
use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\brands\Http\Requests\BrandRequest;
use Modules\brands\Repository\BrandRepositoryInterface;

class BrandController extends CustomController
{
    protected $repository;
    protected $title='برند';
    protected $route_params='brands';
    public function __construct(BrandRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $brand=$this->repository->getList($request);
        $trash_brand_count=$this->repository->trashCount();
        return CView('brands::index',['brand'=>$brand,'trash_brand_count'=>$trash_brand_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('brands::create');
    }

    public function store(BrandRequest $request)
    {
        $this->repository->create($request);

        return  [
            'redirect_url'=>url('admin/brands'),
            'message'=>'ثبت برند با موفقیت انجام شد'
        ];
    }
    public function edit($id)
    {
        $brand=$this->repository->find($id);
        return CView('brands::edit',['brand'=>$brand]);
    }
    public function update($id,BrandRequest $request)
    {
        $this->repository->update($id,$request);

        return  [
            'redirect_url'=>url('admin/brands'),
            'message'=>'ویرایش برند با موفقیت انجام شد'
        ];
    }
}
