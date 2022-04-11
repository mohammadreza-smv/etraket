<?php

$option=['url' => 'sellers/panel/messages','method'=>'get','class'=>'search_form'];

$form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

$form->textInput('title','عنوان پیام',[],$req->get('title',''));

$form->btn('جست و جو', 'edit');

$form->close();

?>
