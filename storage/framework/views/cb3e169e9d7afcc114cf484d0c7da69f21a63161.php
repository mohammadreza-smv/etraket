<p style="color:red;font-size:13px">ثبت اطلاعات ارسال سفارشات به این شهر (در صورت نیاز)</p>

<?php $__currentLoopData = $sending_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p class="send_type_name">تعیین هزینه  برای <?php echo e($type->type_name); ?></p>

    <?php
      $form->numberInput($type->type_key.'_send_time','زمان حدودی ارسال سفارش :',['class'=>'form-control left']);
    ?>
    <?php if($type->price_type==0): ?>
        <?php $label="هزینه ارسال سفارش :"  ?>
    <?php else: ?>
        <?php $label="حداقل هزینه ارسال سفارش :"  ?>
    <?php endif; ?>

    <?php
       $form->numberInput($type->type_key.'_send_price',$label,['class'=>'form-control left']);
    ?>
    <?php
       $form->numberInput($type->type_key.'_min_order_price','حداقل خرید برای ارسال رایگان :',['class'=>'form-control left']);
    ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home2/teraketc/AppCode/modules/sendingType/resource/views/city_inputs.blade.php ENDPATH**/ ?>