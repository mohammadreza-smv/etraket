<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
              ['title'=>'تنظیمات اطلاع رسانی موجود شدن محصولات','url'=>url('admin/notification/product/setting')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=['title'=>'تنظیمات اطلاع رسانی موجود شدن محصولات'];
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
                $option=['url' => 'admin/notification/product/setting'];
                $form=new \App\Lib\FormBuilder(null,$option);
            ?>

            <?php

            $form->select(
                $channelList,
                'product-notification-channel',
                'انتخاب وب سرویس',
                ['dense'=>true],
                $data['product-notification-channel']
            );

            ?>

            <?php $form->textInput('product-notification-api-key','ای پی ای',['validate'=>'required'],$data['product-notification-api-key']); ?>

            <?php $form->textInput('product-notification-line-number','شماره خط',[],$data['product-notification-line-number']); ?>

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

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/productStatusNotification/resource/views/setting.blade.php ENDPATH**/ ?>