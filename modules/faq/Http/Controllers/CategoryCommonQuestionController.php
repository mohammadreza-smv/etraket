<?php

namespace Modules\faq\Http\Controllers;

use Modules\faq\Models\CategoryCommonQuestion;
use App\Http\Controllers\Admin\CustomController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\faq\Repository\CategoryRepositoryInterface;

class CategoryCommonQuestionController extends CustomController
{
    protected  $title='دسته';

    protected  $route_params='category-common-question';

    protected  $repository=null;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $CategoryCommonQuestion=$this->repository->getList($request);
        $trash_common_question_cat_count=$this->repository->trashCount();
        return CView('faq::category_common_question.index',['CategoryCommonQuestion'=>$CategoryCommonQuestion,'trash_common_question_cat_count'=>$trash_common_question_cat_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('faq::category_common_question.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,['title'=>'required','pic'=>'image'],[],['title'=>'نام دسته','pic'=>'ایکون دسته']);
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/category-common-question'),
            'message'=>'ثبت دسته با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $CategoryCommonQuestion=$this->repository->find($id);
        return CView('faq::category_common_question.edit',['CategoryCommonQuestion'=>$CategoryCommonQuestion]);
    }

    public function update($id,Request $request)
    {
        $this->validate($request,['title'=>'required','pic'=>'image'],[],['name'=>'نام دسته','pic'=>'ایکون دسته']);
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/category-common-question'),
            'message'=>'ویرایش دسته با موفقیت انجام شد'
        ];
    }
}
