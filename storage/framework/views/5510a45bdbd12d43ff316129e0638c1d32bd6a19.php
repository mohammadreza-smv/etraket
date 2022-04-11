<?php

     $option=['url' => 'user/profile/messages','method'=>'get','class'=>'search_form'];

     $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

     $form->textInput('title','عنوان پیام',[],$req->get('title',''));

     $form->btn('جست و جو', 'edit');

     $form->close();

?>
<?php /**PATH /home/teraketc/AppCode/modules/messages/resource/views/userPanel/_searchForm.blade.php ENDPATH**/ ?>