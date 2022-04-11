<?php

namespace Modules\questions\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\questions\Repository\QuestionRepositoryInterface;

class QuestionController extends CustomController
{
    protected $title='پرسش';

    protected $route_params='questions';

    protected $repository=null;

    public function __construct(QuestionRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $questions=$this->repository->getList($request);
        $trash_question_count=$this->repository->trashCount();
        return CView('questions::panel.index',
            [
                'questions'=>$questions,
                'trash_question_count'=>$trash_question_count,
                'req'=>$request
            ]);
    }
    public function change_status(Request $request)
    {
        $result='error';
        $result=$this->repository->change_status($request);
        return $result;
    }
    public function addAnswer($id,Request $request)
    {
        $answer=$request->get('answer');
        if(!empty($answer))
        {
            $this->repository->answer($request,$id,$answer);
            return  [
                'status'=>'ok',
                'message'=>'ثبت پاسخ با موفقیت انجام شد',
                'redirect_url'=>url('admin/questions')
            ];
        }
        else{
            return  [
                'status'=>'error',
                'message'=>'خطا در ثبت اطلاعات،مجددا تلاش نمایید'
            ];
        }
    }
}
