<?php

namespace Modules\faq\Http\Controllers;

use Modules\faq\Models\CategoryCommonQuestion;
use Modules\faq\Models\CommonQuestion;
use App\Http\Controllers\Admin\CustomController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\faq\Repository\QuestionRepositoryInterface;

class CommonQuestionController extends CustomController
{
    protected  $title='پرسش  متداول';

    protected  $route_params='common-question';

    protected  $repository=null;

    public function __construct(QuestionRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $CommonQuestion=$this->repository->getList($request);
        $trash_common_question_count=$this->repository->trashCount();
        return CView('faq::common_question.index',['CommonQuestion'=>$CommonQuestion,'trash_common_question_count'=>$trash_common_question_count,'req'=>$request]);
    }

    public function create()
    {
        $cat=$this->repository->getCat();
        return CView('faq::common_question.create',['cat'=>$cat]);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            ['title'=>'required','cat_id'=>'required','small_answer'=>'required'],[],
            ['title'=>'عنوان پرسش','cat_id'=>'دسته','answer'=>'پاسخ','small_answer'=>'پاسخ کوتاه'
            ]);
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/common-question'),
            'message'=>'ثبت پرسش با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $CommonQuestion= $this->repository->find($id);
        $cat= $this->repository->getCat();
        return CView('faq::common_question.edit',['CommonQuestion'=>$CommonQuestion,'cat'=>$cat]);
    }

    public function update($id,Request $request)
    {
        $this->validate($request,
            ['title'=>'required','cat_id'=>'required','small_answer'=>'required'],[],
            ['title'=>'عنوان پرسش','cat_id'=>'دسته','answer'=>'پاسخ','small_answer'=>'پاسخ کوتاه'
            ]);

        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/common-question'),
            'message'=>'ویرایش پرسش با موفقیت انجام شد'
        ];
    }
}
