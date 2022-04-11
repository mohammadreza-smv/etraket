<div class="panel_content">

    <?php
    $option=['url' => 'admin/setting/sending_type','files'=>true];
    $data=isset($send_type) ? $send_type : [];
    $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($error); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $form->textInput('type_name','عنوان ',['validate'=>'required']); ?>

    <?php $form->textInput('type_key','عنوان لاتین ',['validate'=>'required']); ?>

    <?php $form->textInput('send_type_name','شیوه ارسال مرسوله ',[]); ?>

    <?php $form->fileInput('pic','ایکون',[]); ?>

    <div class="form-group" style="display:flex;">

        <?php
            $form->numberInput('weight1','محدوده وزن محصول ',
                [], null
            );
        ?>
        <span style="padding:7px">تا</span>
        <?php
            $form->numberInput('weight2',null,
                [], null
            );
        ?>
        <span style="padding:7px">کیلوگرم</span>
    </div>


    <?php $form->select([0=>'ثابت',1=>'متغیر (پس کرایه)'],'price_type','شیوه تعیین هزینه ارسال ',['class'=>'selectpicker auto_width']); ?>

    <?php $form->btn( $type=='create' ? 'ثبت' : 'ویرایش', $type); ?>

    <?php $form->close(); ?>

</div>
<?php /**PATH /home2/teraketc/AppCode/modules/sendingType/resource/views/_form.blade.php ENDPATH**/ ?>