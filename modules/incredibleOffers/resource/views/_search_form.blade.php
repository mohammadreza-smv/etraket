<?php
   $args=[];
   $args['title']='جست و جو';
?>

<x-panel-box :args="$args">

    <?php
        $option=['url' => 'admin/incredible-offers','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
    ?>

    <?php

        $form->textInput('search_text','نام محصول',[],$req->get('string',''));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


</x-panel-box>
