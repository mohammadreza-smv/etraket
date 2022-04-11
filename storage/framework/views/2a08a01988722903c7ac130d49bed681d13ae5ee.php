<div class="panel_content">

    <?php
    $option=['url' => 'admin/city'];
    $data=isset($city) ? $city : [];
    $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('name','نام شهر',['validate'=>'required']); ?>

    <?php $form->select($province,'province_id','انتخاب استان',['validate'=>'required']); ?>

    <?php $form->btn( $type=='create' ? 'ثبت' : 'ویرایش ', $type); ?>

    <?php $form->close(); ?>

</div>
<?php /**PATH /home/teraketc/AppCode/modules/city/resource/views/_form.blade.php ENDPATH**/ ?>