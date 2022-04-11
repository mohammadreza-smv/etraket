<?php
   $args=['title'=>'جست و جو'];
?>

<x-seller-panel-box :args="$args">

    <?php
        $option=['url' => 'sellers/panel/orders','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
    ?>

    <?php

        $form->textInput('title','عنوان محصول',[],$req->get('title',''));

        $form->dateInput('date','تاریخ ثبت',[],$req->get('date',''));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


</x-seller-panel-box>
