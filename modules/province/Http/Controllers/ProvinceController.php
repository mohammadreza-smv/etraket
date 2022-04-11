<?php

namespace Modules\province\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\province\Repository\ProvinceRepositoryInterface;


class ProvinceController extends CustomController
{
    protected  $title='استان';

    protected $route_params='province';

    protected $repository;

    public function __construct(ProvinceRepositoryInterface $repository)
    {
       $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $province=$this->repository->getList($request);
        $trash_province_count=$this->repository->trashCount();
        return CView('province::index',['province'=>$province,'trash_province_count'=>$trash_province_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('province::create');
    }

    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required'],[],['name'=>'نام استان']);
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/province'),
            'message'=>'ثبت استان با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $province=$this->repository->find($id);
        return CView('province::edit',['province'=>$province]);
    }

    public function update($id,Request $request)
    {
        $this->validate($request,['name'=>'required'],[],['name'=>'نام استان']);
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/province'),
            'message'=>'ویرایش نام استان با موفقیت انجام شد'
        ];
    }
}
