<?php

namespace Modules\messages\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\messages\Http\Requests\MessageRequest;
use Modules\messages\Repository\MessageRepositoryInterface;

class MessageController extends CustomController
{
    protected $title='پیام';

    protected $route_params='messages';

    protected $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $messages=$this->repository->getList($request,0,null);
        $types=CompleteData('add_message_type',[
           'Modules\users\Models\User'=>[
               'url_param'=>'users',
               'attr'=>'name'
           ]
        ]);
        $trash_message_count=$this->repository->trashCount();
        return CView('messages::panel.index', [
            'messages'=> $messages,
            'req'=>$request,
            'trash_message_count'=>$trash_message_count,
            'types'=>$types
        ]);
    }

    public function show($id){
        $message=$this->repository->show($id);
        $types=CompleteData('add_message_type',[
            'Modules\users\Models\User'=>[
                'url_param'=>'users',
                'attr'=>'name'
            ]
        ]);
        return CView('messages::panel.show',compact('message','types'));
    }

    public function addAnswer($id,MessageRequest $request)
    {
        $user_id = $request->user()->id;
        $this->repository->addAnswer($id,$user_id,$request);
        return  [
            'redirect_url'=>url('admin/messages/'.$id),
            'message'=>'ثبت با موفقیت انجام شد'
        ];
    }
}
