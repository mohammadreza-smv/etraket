<?php
   $args=[];
   $args['title']='جست و جو';
?>

<x-panel-box :args="$args">

    <?php

        $option=['url' => 'admin/affiliate/commissions','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);

    ?>

        @if(array_key_exists('',$categories))
            <?php unset($categories['']) ?>
        @endif

        @if(array_key_exists('',$brands))
            <?php unset($brands['']) ?>
        @endif

    <?php

        $form->select($categories,'cat_id','انتخاب دسته',['dense'=>true],$req->get('cat_id'));

        $form->select($brands,'brand_id','انتخاب برند',['dense'=>true],$req->get('brand_id'));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


</x-panel-box>
