<?php

namespace Modules\categories\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\categories\Http\Requests\CategoryRequest;
use Modules\categories\Repository\CategoryRepositoryInterface;

class CategoryController extends CustomController
{
    protected $title='دسته';

    protected $route_params='category';

    protected $repository=null;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $category=$this->repository->getList($request);
        $trash_cat_count=$this->repository->trashCount();
        return CView('categories::index',['category'=>$category,'trash_cat_count'=>$trash_cat_count,'req'=>$request]);
    }

    public function create()
    {
        $catList=$this->repository->catList();
        return CView('categories::create',['catList'=>$catList]);
    }

    public function store(CategoryRequest $request)
    {
        $this->repository->create($request);
        $message='ثبت دسته با موفقیت انجام شد';

        return  [
            'redirect_url'=>url('admin/category'),
            'message'=>$message
        ];

    }

    public function edit($id)
    {
       $category=$this->repository->find($id);
       $catList=$this->repository->catList();
       return CView('categories::edit',['category'=>$category,'catList'=>$catList]);
    }

    public function update($id,CategoryRequest $request)
    {
        $this->repository->update($id,$request);

        $message='ویرایش دسته با موفقیت انجام شد';

        return  [
            'redirect_url'=>url('admin/category'),
            'message'=>$message
        ];
    }
}
