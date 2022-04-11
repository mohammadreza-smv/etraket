<?php

namespace Modules\colors\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\colors\Repository\ColorRepositoryInterface;

class ColorController extends CustomController
{
    protected $title='رنگ';
    protected $route_params='colors';
    protected $repository=null;
    public function __construct(ColorRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $color=$this->repository->getList($request);
        $trash_color_count=$this->repository->trashCount();
        return CView('colors::index',['color'=>$color,'trash_color_count'=>$trash_color_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('colors::create');
    }

    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required','code'=>'required'],[],['name'=>'نام رنگ','code'=>'کد رنگ']);
        $this->repository->create($request);

        return  [
            'redirect_url'=>url('admin/colors'),
            'message'=>'ثبت رنگ با موفقیت انجام شد'
        ];

    }

    public function edit($id)
    {
        $color=$this->repository->find($id);
        return CView('colors::edit',['color'=>$color]);
    }

    public function update($id,Request $request)
    {
        $this->validate($request,['name'=>'required','code'=>'required'],[],['name'=>'نام رنگ','code'=>'کد رنگ']);
        $this->repository->update($id,$request);

        return  [
            'redirect_url'=>url('admin/colors'),
            'message'=>'ویرایش رنگ با موفقیت انجام شد'
        ];
    }
}
