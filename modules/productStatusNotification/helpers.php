<?php
use Modules\messages\Models\Message;
function send_message($user,$text){
    if(file_exists(base_path('modules/messages/Models/Message.php'))){
        $time=time();
        $message = new Message();
        $message->parent_id = 0;
        $message->content = $text;
        $message->title='اطلاع رسانی موجود شدن محصول';
        $message->user_id = $user->id;
        $message->user_type ='Modules\users\Models\User';
        $message->from_id = 0;
        $message->from_type = 'Modules\users\Models\User';
        $message->to_type ='Modules\users\Models\User';
        $message->to_id = $user->id;
        $message->time = $time;
        $message->save();
    }
}
