<?php

namespace Modules\blog\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\blog\Http\Requests\BlogCategoryRequest;
use Modules\blog\Repository\BlogCategoryRepositoryInterface;

class BlogCategoriesController extends CustomController
{
    protected $title='دسته';

    protected $route_params='blog/categories';

    protected $repository=null;

    public function __construct(BlogCategoryRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request){
        $category=$this->repository->getList($request);
        $trash_cat_count=$this->repository->trashCount();
        return CView('blog::category.index',[
            'category'=>$category,
            'trash_cat_count'=>$trash_cat_count,
            'req'=>$request
        ]);
    }

    public function create(){
        $categories=$this->repository->parentCategories();
        return CView('blog::category.create',compact('categories'));
    }

    public function store(BlogCategoryRequest $request){
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/blog/categories'),
            'message'=>'ثبت دسته با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $category=$this->repository->find($id);
        $categories=$this->repository->parentCategories();
        return CView('blog::category.edit',compact('categories','category'));
    }

    public function update($id,BlogCategoryRequest $request)
    {
        $this->repository->update($id,$request);

        $message='ویرایش دسته با موفقیت انجام شد';

        return  [
            'redirect_url'=>url('admin/blog/categories'),
            'message'=>$message
        ];
    }
}
