<?php
$args=[];
$args['title']='جست و جو';
?>

<x-seller-panel-box :args="$args">

    <?php
         $option=['url' => 'sellers/panel/payment','method'=>'get','class'=>'search_form'];

         $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);
    ?>

    <?php

    $form->dateInput('date','تاریخ پرداخت',[],$req->get('date',''));

    $form->btn('جست و جو', 'edit');

    $form->close();

    ?>


</x-seller-panel-box>
