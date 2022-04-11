<?php


namespace Modules\messages\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\messages\Models\Message;

class EloquentMessageRepository extends EloquentBaseRepository implements MessageRepositoryInterface
{
    protected $model='Modules\messages\Models\Message';

    public function trashCount()
    {
        return Message::onlyTrashed()->count();
    }

    public function getList($request,$user_id,$type)
    {
        return Message::getMessage($user_id,$type,$request->all());
    }

    public function show($id)
    {
        $message = Message::with(['getAnswer'=>function($query){
            $query->with(['to','from']);
        }])->where(['id' => $id,'parent_id'=>0])->withTrashed()->firstOrFail();
        if($message->status==1){
            $message->status=0;
            $message->update();
        }
        return $message;
    }

    public function addMessage($request, $user, $user_id,$user_type,$to_type='Modules\users\Models\User',$parent = null)
    {
        $time = time();
        $message = new Message($request->all());
        $message->parent_id = 0;
        $message->user_id = $user->id;
        $message->user_type =$user_type;
        $message->from_id = $user_id;
        $message->from_type = $user_type;
        $message->to_type =$to_type;
        $message->to_id = $user->id;
        $message->time = $time;
        $img_url = upload_file($request, 'pic', 'upload');
        if ($img_url) {
            $message->file = $img_url;
        }
        $message->save();
        $message=$parent==null ? $message : $parent;
        //send_notification($parent_id,$message->user_id,$user_type,$message);
    }

    public function addAnswer($message_id, $user_id, $request,$to_type=null,$status=-1,$from_type='Modules\users\Models\User')
    {
        $message = Message::where(['id' => $message_id,'parent_id' => 0])->firstOrFail();
        $time = time();
        $answer = new Message($request->all());
        $answer->parent_id = $message->id;
        $answer->from_type =$from_type;
        $answer->from_id = $user_id;
        $answer->user_type =$message->user_type;
        $answer->to_type =$to_type ? $to_type : $message->user_type;
        $answer->to_id = $message->to_id==0 ? $message->from_id : $message->to_id;
        $answer->time = $time;
        $answer->user_id =$message->user_id;
        $img_url = upload_file($request, 'pic', 'upload');
        if ($img_url) {
            $answer->file = $img_url;
        }
        $message->status=$status;
        $message->save();
        $answer->save();
        //send_notification($answer->parent_id,$answer->user_id, $answer->user_type,  $message);
    }

    public function getUserMessageContent($id, $user_id,$user_type)
    {
        $message = Message::with(['getAnswer'=>function($query){
            $query->with(['to','from']);
        }])->where(['id' => $id,'parent_id'=>0,'user_id'=>$user_id,'user_type'=>$user_type])->firstOrFail();
        if($message->status==-1){
            $message->status=0;
            $message->update();
        }
        return $message;
    }

    public function addUserMessage($user_type, $user_id,$request)
    {
        $time=time();
        $message = new Message($request->all());
        $message->parent_id = 0;
        $message->user_id = $user_id;
        $message->user_type = $user_type;
        $message->from_id = $user_id;
        $message->from_type =$user_type;
        $message->to_type = $user_type;
        $message->to_id =0;
        $message->time = $time;
        $img_url = upload_file($request, 'pic', 'upload');
        if ($img_url) {
            $message->file = $img_url;
        }
        $message->save();
    }

    public function getNuwUserMessageCount($user_id){
        $count=Message::where(['user_id'=>$user_id,'user_type'=>'Modules\users\Models\User','status'=>-1,'parent_id'=>0])->count();
        return $count;
    }

    public function count($where)
    {
       return Message::where($where)->count();
    }
}
