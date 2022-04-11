<?php


namespace Modules\messages\Repository;


use App\Repositories\BaseInterface;

interface MessageRepositoryInterface
{
    public function trashCount();

    public function getList($request,$user_id,$type);

    public function show($id);

    public function addMessage($request, $user, $user_id,$user_type,$to_type='Modules\users\Models\User',$parent=null);

    public function addAnswer($message_id,$user_id,$request,$to_type,$status);

    public function getUserMessageContent($id,$user_id,$user_type);

    public function addUserMessage($user_type,$user_id,$request);

    public function getNuwUserMessageCount($user_id);

    public function count($where);
}
