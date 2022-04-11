<div class="panel_content">

    <?php
    $option=['url' => 'admin/warranties'];
    $data=isset($warranty) ? $warranty : [];
    $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('name','نام گارانتی ',['validate'=>'required']); ?>


    <?php $form->btn( $type=='create' ? 'ثبت گارانتی' : 'ویرایش گارانتی', $type); ?>

    <?php $form->close(); ?>

</div>
