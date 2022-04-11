<?php

namespace Modules\messages\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\messages\Http\Requests\MessageRequest;
use Modules\messages\Repository\MessageRepositoryInterface;

class UserMessageController extends Controller
{
    protected $url_param='';

    protected $type='';

    protected $user;

    protected $types;

    protected $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->types=CompleteData('add_message_type',[
            'Modules\users\Models\User'=>[
                'url_param'=>'users',
                'attr'=>'name'
            ]
        ]);
        $this->repository=$repository;
        parent::__construct();
    }

    public function index($id,Request $request)
    {
        $this->setUserType($request,$id);
        $user_id=$this->user->id;
        $messages=$this->repository->getList($request,$user_id,$this->type);
        return CView('messages::panel.user_message_list', [
            'user' => $this->user,
            'messages'=> $messages,
            'req'=>$request,
            'type'=> $this->type,
            'url_param'=>$this->url_param,
            'types'=> $this->types
        ]);
    }

    public function create($id,Request $request)
    {
        $this->setUserType($request,$id);
        return CView('messages::panel.add_message',[
            'user'=> $this->user,
            'type'=> $this->type,
            'url_param'=>$this->url_param,
            'types'=> $this->types
        ]);
    }

    public function store($id,MessageRequest $request)
    {
        $this->setUserType($request,$id);
        $user_id=$request->user()->id;
        $this->repository->addMessage($request,$this->user,$user_id,$this->type);
        return  [
            'redirect_url'=>url('admin/'.$this->url_param.'/'.$id.'/messages'),
            'message'=>'ثبت با موفقیت انجام شد'
        ];
    }

    public function show($user_id,$id,Request $request)
    {
        $this->setUserType($request,$user_id);
        $message = Message::with(['getAnswer'=>function($query){
            $query->with(['to','from']);
        }])->where(['id' => $id, 'user_id' => $user_id, 'user_type' =>$this->type,'parent_id'=>0])->firstOrFail();
        if($message->status==1){
            $message->status=0;
        }
        $message->update();
        return view('messages.message_content', ['user' => $this->user, 'message'=> $message,'type'=> $this->type,'url_param'=>$this->url_param]);
    }
    public function addAnswer($user_id,$id,MessageRequest $request)
    {
        $admin_id = $request->user()->id;
        $this->setUserType($request,$user_id);
        $message = Message::where(['id' => $id, 'user_id' => $user_id, 'user_type' => $this->type, 'parent_id' => 0])->firstOrFail();
        addMessage($request, $this->user, $admin_id,$id,$this->type,$message);
        return redirect()->back()->with('message', 'ثبت با موفقیت انجام شد');
    }
    protected function  setUserType($request,$id)
    {
        $uri=$request->route()->uri;
        $e=explode('/',$uri);
        foreach ($this->types as $key=>$type){
            if($type['url_param']==$e[1]){
                $this->url_param=$type['url_param'];
                $this->type=$key;
                define('message_user_type', $this->type);
                $class=$this->type;
                $this->user = $class::findOrFail($id);
            }
        }
    }
}
