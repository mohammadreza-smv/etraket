<div class="panel_content">

    <?php
    $option=['url' => 'admin/colors'];
    $data=isset($color) ? $color : [];
    $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('name','نام رنگ ',['validate'=>'required']); ?>

    <?php $form->colorInput('code','کد رنگ ',['validate'=>'required']); ?>

    <?php $form->btn( $type=='create' ? 'ثبت رنگ' : 'ویرایش رنگ', $type); ?>

    <?php $form->close(); ?>

</div>
<?php /**PATH /home2/teraketc/AppCode/modules/colors/resource/views/_form.blade.php ENDPATH**/ ?>