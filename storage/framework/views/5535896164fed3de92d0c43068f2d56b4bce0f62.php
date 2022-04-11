<?php $__env->startSection('content'); ?>

   <div>

       <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تعیین هزینه ارسال سفارشات','url'=>url('admin/setting/send-order-price')],
       ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

       <?php
       $args=[];
       $args['title']='تعیین هزینه ارسال سفارشات';
       ?>

       <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

           <?php
           $option=['url' => 'admin/setting/order/send-price'];
           $form=new \App\Lib\FormBuilder($errors,$option);
           ?>

           <?php $__currentLoopData = $send_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <p class="send_type_name">تعیین هزینه  برای <?php echo e($type->type_name); ?></p>

               <?php $form->numberInput(
                   $type->type_key.'_send_time',
                   'زمان حدودی ارسال سفارش ',
                   ['class'=>'left'],
                   $data[$type->type_key.'_send_time']
               ); ?>

               <?php if($type->price_type==0): ?>
                   <?php $label="هزینه ارسال سفارش"  ?>
               <?php else: ?>
                   <?php $label="حداقل هزینه ارسال سفارش"  ?>
               <?php endif; ?>


               <?php $form->numberInput(
                   $type->type_key.'_send_price',
                   $label,
                   ['class'=>'left'],
                   $data[$type->type_key.'_send_price']
               ); ?>

               <?php $form->numberInput(
                   $type->type_key.'_min_order_price',
                   'حداقل خرید برای ارسال رایگان',
                   ['class'=>'left'],
                   $data[$type->type_key.'_min_order_price']
               ); ?>

           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

           <?php $form->btn('ثبت', 'create'); ?>

           <?php $form->close(); ?>

        <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

   </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sendingType/resource/views/send_order_price.blade.php ENDPATH**/ ?>