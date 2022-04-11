<?php $__env->startSection('content'); ?>

     <div>

         <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
               ['title'=>'تنظیمات ارسال پیامک به کاربران','url'=>url('admin/user/sms/channel')],
         ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <?php
         $args=[];
         $args['title']='تنظیمات ارسال پیامک به کاربران';
         ?>

         <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

             <?php
                 $option=['url' => 'admin/user/sms/channel'];
                 $form=new \App\Lib\FormBuilder($errors,$option);
             ?>

             <?php

             $form->select(
                 $channelList,
                 'users-channel',
                 'انتخاب وب سرویس',
                 [],
                 $data['users-channel']
             );

             ?>

             <?php $form->textInput('users-api-key','ای پی ای',['validate'=>'required'],$data['users-api-key']); ?>

             <?php $form->textInput('users-line_number','شماره خط',[],$data['users-line_number']); ?>


             <?php $form->textInput('users-active_template','قالب ارسال کد فعال سازی ',[],$data['users-active_template']); ?>

             <?php $form->btn('ثبت اطلاعات', 'create'); ?>

             <?php $form->close(); ?>

          <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

     </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/panel/sms_setting.blade.php ENDPATH**/ ?>