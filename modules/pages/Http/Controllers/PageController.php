<?php

namespace Modules\pages\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\pages\Repository\PageRepositoryInterface;

class PageController extends CustomController
{
    protected $title='صفحه';

    protected $route_params='pages';

    protected $repository=null;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $pages=$this->repository->getList($request);
        $trash_page_count=$this->repository->trashCount();
        return CView('pages::panel.index',['pages'=>$pages,'trash_page_count'=>$trash_page_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('pages::panel.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,['title'=>['required','unique:pages'],'content'=>'required'],[],['title'=>'عنوان صفحه','content'=>'محتوای صفحه']);
        $this->repository->create($request);

        return  [
            'redirect_url'=>url('admin/pages'),
            'message'=>'ثبت صفحه با موفقیت انجام شد'
        ];
    }

    public function edit($id){
        $page=$this->repository->find($id);
        return CView('pages::panel.edit',['page'=>$page]);
    }

    public function update($id,Request $request)
    {
        $this->validate($request,['title'=>['required','unique:pages,title,'.$id.''],'content'=>'required'],[],['title'=>'عنوان صفحه','content'=>'محتوای صفحه']);
        $this->repository->update($id,$request);

        return  [
            'redirect_url'=>url('admin/pages'),
            'message'=>'ویرایش صفحه با موفقیت انجام شد'
        ];
    }

}
