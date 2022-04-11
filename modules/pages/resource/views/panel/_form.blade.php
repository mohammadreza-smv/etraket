<div class="panel_content">
    <?php
    $option=['url' => 'admin/pages'];
    if($type=='edit'){
        $form=new \App\Lib\FormBuilder($errors,$option, $type,$page);
    }
    else{
        $form=new \App\Lib\FormBuilder($errors,$option);
    }
    ?>


    <?php $form->textInput('title', 'عنوان صفحه', ['class'=>'total-width','validate'=>'required']) ?>

    <?php $form->editor('content',['class'=>'total-width']); ?>

    <?php $form->tagBox('keywords','برچسب ها',[]); ?>

    <?php  $form->textarea('description','توضیحات مختصر در مورد محصول (حداکثر 150 کاراکتر)',['class'=>'total-width']) ?>

    <?php $form->btn( $type=='create' ? 'افزودن صفحه' : 'ویرایش صفحه', $type); ?>

    <?php $form->close() ?>

</div>
