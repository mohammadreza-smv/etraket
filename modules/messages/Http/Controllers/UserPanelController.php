<?php


namespace Modules\messages\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\messages\Http\Requests\MessageRequest;
use Modules\messages\Repository\MessageRepositoryInterface;
use Auth;
use Session;
class UserPanelController extends Controller
{
    protected $repository;

    public function __construct(Request $request,MessageRepositoryInterface $repository)
    {
        $this->repository=$repository;
        parent::__construct();
    }

    public function getUserMessage(Request $request)
    {
        $user_id=$request->user()->id;

        $messages=$this->repository->getList($request,$user_id,'Modules\users\Models\User');

        config()->set('view.build_component','add');

        return CView('messages::'.$this->view . 'userPanel.messages',
            [
                'messages'=>$messages,
                'req'=>$request,
                'themeType'=>$this->view
        ]);
    }
    public function addMessageForm()
    {
        $user_id=Auth::user()->id;
        config()->set('view.build_component','add');
        return CView('messages::'.$this->view . 'userPanel.add_message',[
            'themeType'=>$this->view
        ]);
    }
    public function addMessage(MessageRequest $request)
    {
        $user_id=$request->user()->id;
        $user_type='Modules\users\Models\User';
        $this->repository->addUserMessage($user_type,$user_id,$request);
        Session::flash('add-message','ثبت پیام با موفقیت انجام شد');
        return [
            'redirect_url'=>url('user/profile/messages')
        ];
    }
    public function showMessageContent($id,Request $request)
    {
        $user_id=$request->user()->id;
        $user_type='Modules\users\Models\User';
        $message=$this->repository->getUserMessageContent($id,$user_id,$user_type);
        $themeType=$this->view;
        config()->set('view.build_component','add');
        return CView('messages::'.$this->view . 'userPanel.message_content',
            compact('message','user_type','themeType'));
    }
    public function addAnswer($id,MessageRequest $request)
    {
        $user_id = $request->user()->id;
        $user_type='Modules\users\Models\User';
        $this->repository->addAnswer($id,$user_id,$request,$user_type,'1');
        Session::flash('add-message','ثبت  با موفقیت انجام شد');
        return [
            'redirect_url'=>url('user/profile/messages/'.$id)
        ];
    }
}
