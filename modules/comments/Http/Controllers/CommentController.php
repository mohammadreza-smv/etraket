<?php

namespace Modules\comments\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use DB;
use Modules\comments\Repository\CommentRepositoryInterface;

class CommentController extends CustomController
{
    protected $title='نظر';

    protected $route_params='comments';

    protected $repository;

    public function __construct(CommentRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $comments=$this->repository->getList($request);

        $trash_comment_count=$this->repository->trashCount();

        return CView('comments::panel.index',[
            'comments'=>$comments,
            'trash_comment_count'=>$trash_comment_count,
            'req'=>$request
        ]);
    }

    public function change_status(Request $request)
    {
        $result='error';
        $result=$this->repository->update(0,$request);
        return $result;
    }

    public function getComment(Request $request,CommentRepositoryInterface $repository){
        return $repository->product_comments($request);
    }
}
