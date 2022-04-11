<?php
$args=[];
$args['title']='جست و جو';
?>

<x-panel-box :args="$args">

    <?php

    $option=['url' => 'admin/users','method'=>'get','class'=>'search_form'];

    $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

    $form->textInput('name','نام کاربر',[],$req->get('name',''));

    $form->textInput('mobile','شماره موبایل',[],$req->get('mobile',''));

    $form->select($roles,'role','نقش کاربری',['class'=>'total-width'],$req->get('role',''));

    $form->btn( 'جست و جو', 'edit');

    $form->close();

    ?>
</x-panel-box>
