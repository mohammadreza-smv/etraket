<?php
   $args=[];
   $args['title']='جست و جو';
?>

<x-panel-box :args="$args">

    <?php
        $u=isset($url) ? $url : "admin/messages";
        $option=['url' => $u,'method'=>'get','class'=>'search_form'];
        $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);
    ?>

    <?php

        $form->textInput('title','عنوان پیام',[],$req->get('title',''));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


</x-panel-box>
