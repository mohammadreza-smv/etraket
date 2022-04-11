<?php
  $args=[];
  $args['title']='جست و جو';
?>

<x-panel-box :args="$args">

    <?php

        $option=['url' => request()->url(),'method'=>'GET','class'=>'search_form'];
        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

        $form->textInput('submission_id','',['class'=>'form-control','placeholder'=>"کد مرسوله"],$req->get('submission_id',''));


        $form->btn( 'جست و جو', 'edit');

        $form->close();

    ?>
</x-panel-box>
