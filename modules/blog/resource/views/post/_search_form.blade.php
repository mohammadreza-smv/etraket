<?php
   $args=[];
   $args['title']='جست و جو';
?>

<x-panel-box :args="$args">

    <?php
        $option=['url' => 'admin/blog/posts','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);

        $form->textInput('title','عنوان پست',[],$req->get('title',''));

        $form->select($categories,'cat_id','دسته',['dense'=>true],$req->get('cat_id',''));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


</x-panel-box>
