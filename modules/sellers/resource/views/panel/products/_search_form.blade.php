<?php
   $args=[];
   $args['title']='جست و جو';
   $url=isset($url) ? $url : 'sellers/panel/products';
?>

<x-seller-panel-box :args="$args">

    <?php
        $option=['url' =>$url,'method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
    ?>

    <?php

        $form->textInput('search_text','عنوان محصول',[],$req->get('search_text',''));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


</x-seller-panel-box>
